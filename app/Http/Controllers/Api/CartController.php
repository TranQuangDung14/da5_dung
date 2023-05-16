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
        // dd($request->user()->id);
        // dd('non',$request->all(),'adad');
        return $request->user()->id;
    }


    public function getCart()
    {
        // dd(auth()->user());
        $cart = auth()->user()->cart;
        if (!$cart) {
            return response()->json([
                'message' => 'Giỏ hàng của bạn hiện đang trống!'
            ]);
        }
        $cart->load('cartDetails.product.images');

        return response()->json($cart);
    }

    public function addProduct(Request $request)
    {
          // Kiểm tra đăng nhập
    if (!auth()->check()) {
        return response()->json(['message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng'], 401);
    }

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
            return response()->json([
                'message' => 'Thêm lỗi'
            ]);
        }
    }

    public function updateQuantity(Request $request, Carts_details $cartDetail)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $previousQuantity = $cartDetail->quantity;
        $newQuantity = $request->quantity;
        $quantityDifference = $newQuantity - $previousQuantity;

        $cartDetail->update(['quantity' => $newQuantity]);

        // Tính toán giá tiền mới
        $productPrice = $cartDetail->product->default_price;
        $priceDifference = $productPrice * $quantityDifference;

        $cart = $cartDetail->cart;
        $totalMoney = $cart->total_money;
        $discountAmount = $cart->discounted_price;
        $realMoney = $cart->real_money;

        $cart->update([
            'total_money' => $totalMoney + $priceDifference,
            'real_money' => $realMoney + $priceDifference
        ]);

        $cartDetail->update(['price_by_quantity' => $productPrice * $newQuantity]);

        return response()->json(['message' => 'Cập nhật số lượng thành công!']);
    }


    // xóa sản phẩm trong giỏ hàng
    // public function removeProduct(Carts_details $cartDetail)
    // {
    //     $cartDetail->delete();

    //     $this->updateCartTotal($cartDetail->cart);

    //     return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng!']);
    // }

    // public function removeProduct(Carts_details $cartDetail)
    // {
    //     $cartDetail->delete();

    //     $cart = $cartDetail->cart;
    //     $this->updateCartTotal($cart);
    //     $this->removeVoucher($cart);

    //     return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng!']);
    // }

    // private function removeVoucher(Carts $cart)
    // {
    //     $cart->update([
    //         'discounted_price' => null,
    //         'real_money' => $cart->total_money
    //     ]);
    // }
    public function removeProduct(Carts_details $cartDetail)
    {
        $cart = $cartDetail->cart;
        $cartDetail->delete();

        $this->updateCartTotal($cart);

        // Hủy áp dụng voucher
        $cart->update([
            'discounted_price' => 0,
            'real_money' => $cart->total_money
        ]);

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

        $discountAmount = $totalMoney * ($voucher->discount_percentage / 100);
        $realMoney = $totalMoney - $discountAmount;
        $cart->update([
            'discounted_price' => $discountAmount,
            'real_money' => $realMoney
        ]);

        return response()->json(['message' => 'Voucher áp dụng thành công']);
    }

    private function updateCartTotal(Carts $cart)
    {
        $totalMoney = $cart->cartDetails->sum(function ($cartDetail) {
            return $cartDetail->product->default_price * $cartDetail->quantity;
        });
        $discountAmount = $cart->discounted_price;
        $realMoney = $totalMoney - $discountAmount;

        $cart->update([
            'total_money' => $totalMoney,
            'real_money' => $realMoney
        ]);
    }
    // private function updateCartTotal(Carts $cart)
    // {
    //     $totalMoney = $cart->cartDetails->sum(function ($cartDetail) {
    //         return $cartDetail->product->default_price * $cartDetail->quantity;
    //     });
    //     $discountAmount = $cart->discounted_price;
    //     $realMoney = $totalMoney - $discountAmount;

    //     $cart->update([
    //         'total_money' => $totalMoney,
    //         'real_money' => $realMoney
    //     ]);

    //     // Hủy áp dụng voucher nếu discounted_price không hợp lệ
    //     if ($discountAmount && $realMoney < 0) {
    //         $cart->update([
    //             'discounted_price' => null,
    //             'real_money' => $totalMoney
    //         ]);
    //     }
    // }
}
