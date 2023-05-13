<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Carts_details;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function Test(Request $request)
    {
        // $mang=[2,4,5,2,12,4];
        // dd($mang);
        dd($request->user()->id);
        return $request->user()->id;
    }


    public function getCart()
    {
        $cart = auth()->user()->cart;
        if (!$cart) {
            return response()->json([
                'message' => 'Giỏ hàng của bạn hiện đang trống!'
            ]);
        }
        $cart->load('cartDetails.product');

        return response()->json($cart);
    }


    public function addProduct(Request $request, Carts $dung)
    {
        $input = $request->all();
        $rules = array(
            'product_id' => 'required|exists:da5_product,id',
            'quantity' => 'required|integer|min:1'
        );
        $messages = array(
            'product_id.required' => 'Sản phẩm không được phép trống!',
            'product_id.exists' => 'Sản phẩm không tồn tại trong hệ thống!',
            'quantity.required' => 'Số lượng không được phép trống!',
            'quantity.integer' => 'Số lượng phải là số!',
            'quantity.min' => 'Số lượng ít nhất phải là 1!',
        );
        $validator = Validator::make($input, $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        try {
            $cart = auth()->user()->cart;
            // dd($dung->cartDetails);

            if (!$cart) {
                $cart = new Carts(['customer_id' => auth()->user()->id]);
                $cart->save();
            }
            $cartDetail = $cart->cartDetails()->where('product_id', $request->product_id)->first();

            if ($cartDetail) {
                $cartDetail->update([
                    'quantity' => $cartDetail->quantity + $request->quantity,
                    'price_by_quantity' => $cartDetail->product->default_price * ($cartDetail->quantity + $request->quantity),

                ]);
            } else {
                $product = Product::findOrFail($request->product_id);
                $priceByQuantity = $product->default_price * $request->quantity;
                $cartDetail = new Carts_details([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price_by_quantity' => $priceByQuantity,

                ]);
                $cart->cartDetails()->save($cartDetail);
            }

            $this->updateCartTotal($cart);

            return response()->json([
                'message' => 'Đã thêm sản phẩm vào giỏ hàng'
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'message' => 'Thêm lỗi'
            ]);
        }
    }


    // cập nhật số lượng
    public function updateQuantity(Request $request, Carts_details $cartDetail)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        // cập nhật lại số lượng
        $cartDetail->update(['quantity' => $request->quantity]);

        $this->updateCartTotal($cartDetail->cart);

        return response()->json(['message' => 'Cập nhật số lượng thành công!']);
    }

    // xóa sản phẩm trong giỏ hàng
    public function removeProduct(Carts_details $cartDetail)
    {
        $cartDetail->delete();

        $this->updateCartTotal($cartDetail->cart);

        return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng!']);
    }


    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|exists:vouchers,code'
        ]);

        $cart = auth()->user()->cart;
        $voucher = Voucher::where('code', $request->voucher_code)->first();

        if (!$voucher) {
            return response()->json(['message' => 'Mã voucher không hợp lệ'], 422);
        }

        $totalMoney = $cart->cartDetails->sum(function ($cartDetail) {
            return $cartDetail->product->default_price * $cartDetail->quantity;
        });

        $discountedTotalMoney = $totalMoney * (1 - $voucher->discount_percentage / 100);

        $cart->update(['discounted_price' => $discountedTotalMoney]);

        return response()->json(['message' => 'Voucher áp dụng thành công']);
    }



    private function updateCartTotal(Carts $cart)
    {
        $totalMoney = $cart->cartDetails->sum(function ($cartDetail) {
            return $cartDetail->product->default_price * $cartDetail->quantity;
        });
        $cart->update(['total_money' => $totalMoney]);
    }
}
