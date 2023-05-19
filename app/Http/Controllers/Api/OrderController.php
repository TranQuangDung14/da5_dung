<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_product_list;
use App\Models\Orders_details;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index()
    {
        // dd('day r');
        try {
            $order = Order::with('orderDetails.product.images')->orderBy('id','desc')->get();
            //
            return response()->json([
                'data' => $order,
            ], 200);
        } catch (\Exception $e) {
            dd($e);
        }

        // return Order::all();
    }

    public function updateStatus(Request $request, $id)
    {
        // dd($request->all());
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Cập nhật trạng thái đơn hàng thành công']);
    }

    public function show($id)
    {

        try {
            $order = Order::with('orderDetails.product.images')->findOrFail($id);
            //
            return response()->json([
                'data' => $order,
            ], 200);
        } catch (\Exception $e) {
            dd($e);
        }

        // return Order::all();
    }

    // đơn hàng chưa xử lý
    public function Order_processing()
    {
        $orders = Order::with('orderDetails')->where('status', 1)->get();
        return response()->json(
            $orders
        );
    }
    // đơn hàng đã xuất - đang giao
    public function Orders_are_being_delivered()
    {
        $orders = Order::with('orderDetails')->where('status', 3)->get();
        return response()->json(
            $orders
        );
    }

    // đơn hàng đã giao thành công
    public function Order_success()
    {
        $orders = Order::with('orderDetails')->where('status', 4)->get();
        return response()->json(
            $orders
        );
    }
    // đơn hàng đã hủy
    public function Order_cancel()
    {
        $orders = Order::with('orderDetails')->where('status', 5)->get();
        return response()->json(
            $orders
        );
    }
    public function store(Request $request)
    {
        try {
            // Lấy thông tin giỏ hàng từ request
            $cart = auth()->user()->cart;
            if (!$cart) {
                return response()->json([
                    'message' => 'Giỏ hàng của bạn hiện đang trống!'
                ]);
            }
            $maxId = Order::max('id') + 1;
            $code_order = 'MDH_' . $maxId;

            // Tạo đơn hàng và các chi tiết đơn hàng
            $order = Order::create([
                'customer_id' => $cart->customer_id,
                'code_order' => $code_order,
                'payment_method' => $request->payment_method,
                'total_money' => $cart->real_money,
                'shipping_fee' => $request->shipping_fee,
                'receiver_name' => $request->receiver_name,
                'number_phone' => $request->number_phone,
                'receiver_address' => $request->receiver_address,
                'ward_id' => $request->ward_id,
                'districts_id' => $request->districts_id,
                'provinces_id' => $request->provinces_id,
                // 'status' => 1,
                // 'delivery_date' => $cart->delivery_date,
            ]);

            foreach ($cart->cartDetails as $cartDetail) {
                Orders_details::create([
                    'order_id' => $order->id,
                    'product_id' => $cartDetail->product_id,
                    'price' => $cartDetail->price_by_quantity,
                    'quantity' => $cartDetail->quantity,
                    'discount' => $cartDetail->discount,
                ]);
            }

            // Xóa giỏ hàng sau khi tạo đơn hàng thành công
            $cart->cartDetails()->delete();
            $cart->delete();

            // Trả về response thành công
            return response()->json([
                'message' => 'Đặt hàng thành công.',
                'order_id' => $order->id,
            ]);
        } catch (Exception $e) {
            dd($e);
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi thực hiện đặt hàng.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
