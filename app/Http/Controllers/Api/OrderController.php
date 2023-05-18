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


    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //

    // }

    // // public function store(Request $request)
    // // {

    // //     $data = $request->only('product_id', 'customer_id', 'warehouse_id','total_price','status');
    // //     $status = Order::create($data);

    // //     if ($status)
    // //     {
    // //         return response()->json([
    // //             'messege' => 'Thêm thành công!',
    // //         ], 201);
    // //         return $data;
    // //     } else {
    // //         return response()->json([
    // //             'messege' => 'Thêm thất bại!',
    // //         ], 400);
    // //     }
    // // }
    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {


    //     DB::beginTransaction();
    //     try {
    //         $order = new Order();

    //         $order->total_price = (!empty($request->total_price)) ? $request->total_price : null;
    //         $order->save();

    //         $customer = new Customer();
    //         $customer->order_id = $order->id;
    //         $customer->name = (!empty($request->name)) ? $request->name : null;
    //         $customer->id_user = (!empty($request->id_user)) ? $request->id_user : null;
    //         $customer->date_of_birth = (!empty($request->date_of_birth)) ? $request->date_of_birth : null;
    //         $customer->sex = (!empty($request->sex)) ? $request->sex : null;
    //         $customer->email = (!empty($request->email)) ? $request->email : null;
    //         $customer->adress = (!empty($request->adress)) ? $request->adress : null;
    //         $customer->number_phone = (!empty($request->number_phone)) ? $request->number_phone : null;
    //         $customer->save();

    //         foreach ($request->order_product_list as $order_product) {
    //             Order_product_list::create([
    //                 'order_id' => $order->id,
    //                 // 'product_id' => $order_product['product_id'],
    //                 'qtyTotal' => $order_product['qtyTotal'],
    //                 'price' => $order_product['price'],
    //                 'img_src' => $order_product['img_src'],
    //                 'name' => $order_product['name'],
    //             ]);
    //         }
    //         // dd($order_product->product_id);

    //         DB::commit();
    //         return response()->json([

    //             'messege' => 'thành công rồi',
    //             'order' => $order,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json([
    //             dd($e),
    //             'messege' => 'Thất bại!',
    //         ], 200);
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     // return Order::findOrFail($id);
    //     $order= Order::findOrFail($id);
    //     $customer = Customer::where('order_id','=',$id)->get();
    //     $order_product = Order_product_list::where('order_id','=',$id)->get();
    //     return response()->json([

    //         'order'=>$order,
    //         'order_product'=>$order_product,
    //         'customer'=>$customer,

    //     ], 200);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //

    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $data = $request->only('product_id', 'customer_id', 'total_price', 'status');
    //     $user = Order::findOrFail($id);
    //     $status = $user->update($data);
    //     // $status = Order::create($data);

    //     if ($status) {
    //         return response()->json([
    //             'messege' => 'Sửa thành công !',
    //         ], 201);
    //     } else {
    //         return response()->json([
    //             'messege' => 'Sửa thất bại!',
    //         ], 400);
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $Order = Order::findOrFail($id);
    //     $Order->delete();
    //     return response()->json([
    //         'messege' => 'Xóa thành công!',
    //     ], 200);
    // }
    // đơn hàng chưa xử lý
    public function Order_processing()
    {
        $orders = Order::with('orderDetails')->where('status', 1)->get();
        // $orders = Order::where('status', 1)->get();
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
