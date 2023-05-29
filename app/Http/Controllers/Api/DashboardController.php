<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
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
                ->select(DB::raw('DATE_FORMAT(da5_export_orders.created_at, "%d-%m-%Y") as date, sum(da5_export_order_details.quantity * da5_export_order_details.price) as revenue'))
                ->groupBy(DB::raw('DATE_FORMAT(da5_export_orders.created_at, "%d-%m-%Y")'))
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


    public function orderstatistics()
    {
        try {

            $order_all = Order::count();
            $orders_are_pending = Order::where('status', 1)->count(); //đơn hàng mới tạo
            $orders_wait_for_output = Order::where('status', 2)->count(); //đơn hàng
            $order_delivering = Order::where('status', 3)->count(); // đơn hàng đang giao
            $orders_success = Order::where('status', 4)->count(); // đơn hàng thành công
            $orders_cancel = Order::where('status', 5)->count(); // đơn hàng bị hủy

            return response()->json([
                'order' => $order_all,
                'orders_are_pending' => $orders_are_pending,
                'orders_wait_for_output' => $orders_wait_for_output,
                'order_delivering' => $order_delivering,
                'orders_success' => $orders_success,
                'orders_cancel' => $orders_cancel,
            ]);
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
        }
    }

    // public function getRevenueGrowth()
    // {
    //     try {
    //         // tháng trước+
    //         $lastMonth = DB::table('da5_order')
    //             ->join('da5_order_details', 'da5_order.id', '=', 'da5_order_details.order_id')
    //             ->whereYear('da5_order.created_at', Carbon::now()->subMonth()->year)
    //             ->whereMonth('da5_order.created_at', Carbon::now()->subMonth()->month)
    //             ->sum(DB::raw('da5_order_details.quantity * da5_order_details.price'));
    //         //tháng này
    //         $thisMonth = DB::table('da5_order')
    //             ->join('da5_order_details', 'da5_order.id', '=', 'da5_order_details.order_id')
    //             ->whereYear('da5_order.created_at', Carbon::now()->year)
    //             ->whereMonth('da5_order.created_at', Carbon::now()->month)
    //             ->sum(DB::raw('da5_order_details.quantity * da5_order_details.price'));

    //         $growth = $lastMonth != 0 ? ((($thisMonth - $lastMonth) / $lastMonth))*100 : '∞'; // Trả về '∞' nếu doanh thu tháng trước là 0

    //         return response()->json([
    //             'lastMonthRevenue' => $lastMonth,
    //             'thisMonthRevenue' => $thisMonth,
    //             'growth' => $growth,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
    // tăng trưởng doanh số đơn hàng
    public function getOrderGrowth()
    {
        try {
            $lastMonth = DB::table('da5_order')
                ->whereYear('created_at', Carbon::now()->subMonth()->year)
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->count();

            $thisMonth = DB::table('da5_order')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

            $growth = $lastMonth != 0 ? ((($thisMonth - $lastMonth) / $lastMonth))*100  : '∞'; // Trả về '∞' nếu số lượng đơn hàng tháng trước là 0

            return response()->json([
                'lastMonthOrders' => $lastMonth,
                'thisMonthOrders' => $thisMonth,
                'growth' => $growth,
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // tăng trưởng doanh số khách hàng
    public function getCustomerGrowth()
    {
        try {
            $lastMonth = DB::table('da5_customer')
                ->whereYear('created_at', Carbon::now()->subMonth()->year)
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->count();

            $thisMonth = DB::table('da5_customer')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

            $growth = $lastMonth != 0 ? ((($thisMonth - $lastMonth) / $lastMonth))*100 : '∞'; // Trả về '∞' nếu số lượng khách hàng tháng trước là 0

            return response()->json([
                'lastMonthCustomers' => $lastMonth,
                'thisMonthCustomers' => $thisMonth,
                'growth' => $growth,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // tăng trưởng doanh số sản phẩm
    public function getProductGrowth()
    {
        try {
            $lastMonth = DB::table('da5_product')
                ->whereYear('created_at', Carbon::now()->subMonth()->year)
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->count();

            $thisMonth = DB::table('da5_product')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

            $growth = $lastMonth != 0 ? ((($thisMonth - $lastMonth) / $lastMonth))*100  : '∞'; // Trả về '∞' nếu số lượng sản phẩm tháng trước là 0

            return response()->json([
                'lastMonthProducts' => $lastMonth,
                'thisMonthProducts' => $thisMonth,
                'growth' => $growth,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
//     // tăng trưởng doanh số doanh thu
    public function getRevenueGrowth()
    {
        try {
            $lastMonth = DB::table('da5_export_order_details')
                ->join('da5_export_orders', 'da5_export_order_details.export_order_id', '=', 'da5_export_orders.id')
                ->whereYear('da5_export_orders.created_at', Carbon::now()->subMonth()->year)
                ->whereMonth('da5_export_orders.created_at', Carbon::now()->subMonth()->month)
                ->sum(DB::raw('da5_export_order_details.quantity * da5_export_order_details.price'));

            $thisMonth = DB::table('da5_export_order_details')
                ->join('da5_export_orders', 'da5_export_order_details.export_order_id', '=', 'da5_export_orders.id')
                ->whereYear('da5_export_orders.created_at', Carbon::now()->year)
                ->whereMonth('da5_export_orders.created_at', Carbon::now()->month)
                ->sum(DB::raw('da5_export_order_details.quantity * da5_export_order_details.price'));

            $growth = $lastMonth != 0 ? ((($thisMonth - $lastMonth) / $lastMonth))*100 : '∞'; // Trả về '∞' nếu doanh thu tháng trước là 0

            return response()->json([
                'lastMonthRevenue' => $lastMonth,
                'thisMonthRevenue' => $thisMonth,
                'growth' => $growth,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
