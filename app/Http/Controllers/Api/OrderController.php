<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_product_list;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json([
            // 'messege' => 'day la bản test db!',
            // 'data' => Order::all(),
            // 'product' => Product::where('status', 1)->get(),
            // 'customer' => Customer::get(),
            // 'data' => DB::table('da5_order')
            //     ->Join('da5_product', 'da5_order.product_id', '=', 'da5_product.id')
            //     ->Join('da5_customer', 'da5_order.customer_id', '=', 'da5_customer.id')
            //     // ->Join('da5_warehouse','da5_order.product_id','=','da5_warehouse.product_id')
            //     ->Join('da5_status', 'da5_order.status', '=', 'da5_status.id')
            //     ->select('da5_order.*', 'da5_status.name_status', 'da5_product.name as name_product', 'da5_customer.name as name_customer')
            //     ->get(),
            'order'=>DB::table('da5_order')
                ->Join('da5_customer', 'da5_order.id', '=', 'da5_customer.order_id')
                ->Join('da5_order_product_list', 'da5_order.id', '=', 'da5_order_product_list.order_id')
                ->select('da5_order.*', 'da5_customer.name as name_customer','da5_order_product_list.name')
                ->get(),

        ], 200);
        // return Order::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    // public function store(Request $request)
    // {

    //     $data = $request->only('product_id', 'customer_id', 'warehouse_id','total_price','status');
    //     $status = Order::create($data);

    //     if ($status)
    //     {
    //         return response()->json([
    //             'messege' => 'Thêm thành công!',
    //         ], 201);
    //         return $data;
    //     } else {
    //         return response()->json([
    //             'messege' => 'Thêm thất bại!',
    //         ], 400);
    //     }
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        DB::beginTransaction();
        try {
            $order = new Order();

            $order->total_price = (!empty($request->total_price)) ? $request->total_price : null;
            $order->save();

            $customer = new Customer();
            $customer->order_id = $order->id;
            $customer->name = (!empty($request->name)) ? $request->name : null;
            $customer->id_user = (!empty($request->id_user)) ? $request->id_user : null;
            $customer->date_of_birth = (!empty($request->date_of_birth)) ? $request->date_of_birth : null;
            $customer->sex = (!empty($request->sex)) ? $request->sex : null;
            $customer->email = (!empty($request->email)) ? $request->email : null;
            $customer->adress = (!empty($request->adress)) ? $request->adress : null;
            $customer->number_phone = (!empty($request->number_phone)) ? $request->number_phone : null;
            $customer->save();

            foreach ($request->order_product_list as $order_product) {
                Order_product_list::create([
                    'order_id' => $order->id,
                    // 'product_id' => $order_product['product_id'],
                    'qtyTotal' => $order_product['qtyTotal'],
                    'price' => $order_product['price'],
                    'img_src' => $order_product['img_src'],
                    'name' => $order_product['name'],
                ]);
            }
            // dd($order_product->product_id);

            DB::commit();
            return response()->json([

                'messege' => 'thành công rồi',
                'order' => $order,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                dd($e),
                'messege' => 'Thất bại!',
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Order::findOrFail($id);
        $order= Order::findOrFail($id);
        $customer = Customer::where('order_id','=',$id)->get();
        $order_product = Order_product_list::where('order_id','=',$id)->get();
        return response()->json([

            'order'=>$order,
            'order_product'=>$order_product,
            'customer'=>$customer,

        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only('product_id', 'customer_id', 'total_price', 'status');
        $user = Order::findOrFail($id);
        $status = $user->update($data);
        // $status = Order::create($data);

        if ($status) {
            return response()->json([
                'messege' => 'Sửa thành công !',
            ], 201);
        } else {
            return response()->json([
                'messege' => 'Sửa thất bại!',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Order = Order::findOrFail($id);
        $Order->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
