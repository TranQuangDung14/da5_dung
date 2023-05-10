<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Carts_details;
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
    public function addProduct(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'product_id' => 'required|exists:da5_product,id',
        //     'quantity' => 'required|integer|min:1'
        // ]);
        $input = $request->all();
        $rules = array(
            'product_id' => 'required|exists:da5_product,id',
            'quantity' => 'required|integer|min:1'
            // 'price' => 'required',
        );
        $messages = array(
            'product_id.required' => 'sản phẩm không được phép trống!',
            'product_id.exists'=>'sản phẩm không tồn tại trong hệ thống!',
            'quantity.required' => 'số lượng không được phép trống!',
            'quantity.integer' => 'số lượng phải là số!',
            'quantity.min' => 'Số lượng ít nhất phải là 1!',
            // 'price.required' => 'Giá tiền không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        // $baseUrl = env('APP_URL') . '/';
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        try {
            // Nhận giỏ hàng của người dùng
            $cart = auth()->user()->cart;
            // Tạo giỏ hàng mới nếu chưa tồn tại
            if (!$cart) {
                $cart = new Carts(['customer_id' => auth()->user()->id]);
                $cart->save();
            }
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $cartDetail = $cart->cartDetails()->where('product_id', $request->product_id)->first();
            if ($cartDetail) {
                // Cập nhật chi tiết giỏ hàng hiện có
                $cartDetail->update([
                    'quantity' => $cartDetail->quantity + $request->quantity
                ]);
            } else {
                // Thêm chi tiết giỏ hàng mới
                $cartDetail = new Carts_details([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
                $cart->cartDetails()->save($cartDetail);
            }
            // Cập nhật giỏ hàng total_money
            $this->updateCartTotal($cart);

            return response()->json([
                'message' => 'Đã thêm sản phẩm vào giỏ hàng'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Thêm lỗi'
            ]);
        }
    }
    public function getCart()
    {
        $cart = auth()->user()->cart;
        // dd(   $cart->load('cartDetails.product'));
        $cart->load('cartDetails.product');

        return response()->json($cart);
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
            return response()->json(['message' => 'Invalid voucher code'], 422);
        }

        if ($cart->voucher_id) {
            return response()->json(['message' => 'A voucher has already been applied'], 422);
        }

        $cart->update(['voucher_id' => $voucher->id]);

        $this->updateCartTotal($cart);

        return response()->json(['message' => 'Voucher applied']);
    }

    private function updateCartTotal(Carts $cart)
    {
        $totalMoney = $cart->cartDetails->sum(function ($cartDetail) {
            return $cartDetail->product->default_price * $cartDetail->quantity;
        });

        if ($cart->voucher_id) {
            $voucher = Voucher::find($cart->voucher_id);
            $totalMoney *= (1 - $voucher->discount_percentage / 100);
        }

        $cart->update(['total_money' => $totalMoney]);
    }
}
