<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderOutOfStock;
use App\Mail\OrderShipped;
use App\Models\Export_orders;
use App\Models\Export_orders_details;
use App\Models\Order;
use App\Models\Orders_details;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExportOrderController extends Controller
{

    public function getExportOrders()
    {
        $exportOrders = Export_orders::with('order','staff')->get();
        return response()->json(['exportOrders'=> $exportOrders]);
    }
    public function exportOrder(Request $request)
    {
        try {
            // $order = Order::where('status',2)->get();
            // Lấy ID đơn hàng từ request
            $orderId = $request->input('order_id');
            // dd($orderId);

            // Kiểm tra đơn hàng có status = 2 (đơn hàng đã xác nhận) không
            $order = Order::where('status', 2)->findOrFail($orderId);
            // dd($order);
            // Lấy thông tin sản phẩm từ đơn hàng
            $orderDetails = Orders_details::where('order_id', $orderId)->get();
            $customer = User::findOrFail($order->customer_id);
            $email = $customer->email;
            // Kiểm tra số lượng sản phẩm trong đơn hàng và kiểm tra hàng trong kho
            foreach ($orderDetails as $orderDetail) {
                $productId = $orderDetail->product_id;
                $quantity = $orderDetail->quantity;

                $product = Product::findOrFail($productId);

                if ($product->quantity < $quantity) {
                    // Sản phẩm không đủ hàng, gửi thông báo cho khách hàng
                    Mail::to($email)->send(new OrderOutOfStock($order, $orderDetail));
                    return response()->json(['message' => 'Sản phẩm không đủ hàng'], 400);
                }
            }

            // Tạo phiếu xuất kho
            $exportOrder = Export_orders::create([
                'staff_id' => $request->user()->id, // ID nhân viên xuất kho (đăng nhập)
                'order_id'=> $orderId,
                'total_quantity' => $order->total_quantity,
            ]);

            // Tạo chi tiết phiếu xuất kho
            foreach ($orderDetails as $orderDetail) {
                Export_orders_details::create([
                    'export_order_id' => $exportOrder->id,
                    'product_id' => $orderDetail->product_id,
                    'quantity' => $orderDetail->quantity,
                    'price' => $orderDetail->price,
                ]);

                // Giảm số lượng sản phẩm trong kho
                $product = Product::findOrFail($orderDetail->product_id);
                $product->quantity -= $orderDetail->quantity;
                $product->save();
            }

            // Cập nhật trạng thái đơn hàng thành công
            $order->status = 3; // Chuyển trạng thái thành 3 (đã xuất kho)

            $order->delivery_date = $request->delivery_date;
            $order->save();

            // Gửi mail xác nhận đơn hàng
            // Mail::to($order->customer_email)->send(new OrderShipped($order));
            Mail::to($email)->send(new OrderShipped($order));

            return response()->json(['message' => 'Xuất kho thành công']);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
