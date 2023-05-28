<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //
            $product = Product::where('status', 1)->count();
            //    return Product::where('status',1)->count();
            $revenue = DB::table('da5_export_order_details')
                ->join('da5_product', 'da5_export_order_details.product_id', '=', 'da5_product.id')
                ->select(DB::raw('sum(da5_export_order_details.quantity * da5_export_order_details.price) as revenue'))
                ->first();


            // echo "Tổng doanh thu: " . $totalRevenue;
            $order = Order::count();
            $customer = Customer::count();
            return response()->json([
                'product' => $product,
                'order' => $order,
                'customer' => $customer,
                'revenue' => $revenue,
            ]);
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
        }
    }
    //Doanh thu theo ngày
    public function dailyRevenue()
    {
        try {
            $revenue = DB::table('da5_export_order_details')
            ->join('da5_export_orders', 'da5_export_order_details.export_order_id', '=', 'da5_export_orders.id')
            ->select(DB::raw('DATE(da5_export_orders.created_at) as date, sum(da5_export_order_details.quantity * da5_export_order_details.price) as revenue'))
            ->groupBy(DB::raw('DATE(da5_export_orders.created_at)'))
            ->get();

        return response()->json($revenue);
        } catch (\Exception $e) {
            dd($e);
        }

    }
    // Doanh thu theo tháng
    public function monthlyRevenue()
    {
        try {
            $revenue = DB::table('da5_export_order_details')
            ->join('da5_export_orders', 'da5_export_order_details.export_order_id', '=', 'da5_export_orders.id')
            ->select(DB::raw('YEAR(da5_export_orders.created_at) as year, MONTH(da5_export_orders.created_at) as month, sum(da5_export_order_details.quantity * da5_export_order_details.price) as revenue'))
            ->groupBy(DB::raw('YEAR(da5_export_orders.created_at), MONTH(da5_export_orders.created_at)'))
            ->get();

        return response()->json($revenue);
        } catch (\Exception $e) {
            dd($e);
        }

    }
    // Doanh thu theo năm
    public function yearlyRevenue()
    {
        try {
            $revenue = DB::table('da5_export_order_details')
            ->join('da5_export_orders', 'da5_export_order_details.export_order_id', '=', 'da5_export_orders.id')
            ->select(DB::raw('YEAR(da5_export_orders.created_at) as year, sum(da5_export_order_details.quantity * da5_export_order_details.price) as revenue'))
            ->groupBy(DB::raw('YEAR(da5_export_orders.created_at)'))
            ->get();

        return response()->json($revenue);
        } catch (\Exception $e) {
            dd($e);
        }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
