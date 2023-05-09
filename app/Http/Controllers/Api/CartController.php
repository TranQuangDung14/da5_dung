<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Carts_details;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:da5_product,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Get user's cart
        $cart = auth()->user()->cart;

        // Create new cart if not exist
        if (!$cart) {
            $cart = new Carts(['customer_id' => auth()->user()->id]);
            $cart->save();
        }

        // Check if product is already in cart
        $cartDetail = $cart->cartDetails()->where('product_id', $request->product_id)->first();

        if ($cartDetail) {
            // Update existing cart detail
            $cartDetail->update([
                'quantity' => $cartDetail->quantity + $request->quantity
            ]);
        } else {
            // Add new cart detail
            $cartDetail = new Carts_details([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
            $cart->cartDetails()->save($cartDetail);
        }

        // Update cart total_money
        $this->updateCartTotal($cart);

        return response()->json(['message' => 'Product added to cart']);
    }


    public function getCart()
    {
        $cart = auth()->user()->cart;
        $cart->load('cartDetails.product');

        return response()->json($cart);
    }

    public function updateQuantity(Request $request, Carts_details $cartDetail)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartDetail->update(['quantity' => $request->quantity]);

        $this->updateCartTotal($cartDetail->cart);

        return response()->json(['message' => 'Cart updated']);
    }

    public function removeProduct(Carts_details $cartDetail)
    {
        $cartDetail->delete();

        $this->updateCartTotal($cartDetail->cart);

        return response()->json(['message' => 'Product removed from cart']);
    }

    // public function applyVoucher(Request $request)
    // {
    //     $request->validate([
    //         'voucher_code' => 'required|exists:vouchers,code'
    //     ]);

    //     $cart = auth()->user()->cart;

    //     $voucher = Voucher::where('code', $request->voucher_code)->first();

    //     if (!$voucher) {
    //         return response()->json(['message' => 'Invalid voucher code'], 422);
    //     }

    //     if ($cart->voucher_id) {
    //         return response()->json(['message' => 'A voucher has already been applied'], 422);
    //     }

    //     $cart->update(['voucher_id' => $voucher->id]);

    //     $this->updateCartTotal($cart);

    //     return response()->json(['message' => 'Voucher applied']);
    // }

    // private function updateCartTotal(Cart $cart)
    // {
    //     $totalMoney = $cart->cartDetails->sum(function ($cartDetail) {
    //         return $cartDetail->product->default_price * $cartDetail->quantity;
    //     });

    //     if ($cart->voucher_id) {
    //         $voucher = Voucher::find($cart->voucher_id);
    //         $totalMoney *= (1 - $voucher->discount_percentage / 100);
    //     }

    //     $cart->update(['total_money' => $totalMoney]);
    // }
}