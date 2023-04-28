<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Import_orders;
use App\Models\Import_orders_details;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Import_OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('đây');
        try {
            return response()->json([
                'message' => 'đây là nhập kho',
                // 'import_order' =>
                'import_order' => DB::table('da5_import_orders')
                ->leftJoin('da5_import_orders_detail', 'da5_import_orders_detail.import_order_id', '=', 'da5_import_orders.id')
                ->leftJoin('da5_product', 'da5_import_orders_detail.product_id', '=', 'da5_product.id')
                ->select('da5_import_orders.*', 'da5_import_orders_detail.*', 'da5_product.name as name_product')
                ->orderBy('da5_import_orders.id', 'desc')
                ->get(),
            ]);
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
        try {
            $importOrder = new Import_orders();
            $importOrder->staff_id =  $request->user()->id;
            $importOrder->save();

            $product = Product::where('id', $request->product_id)->first();

            // if ($product) {
            $importOrderDetail = new Import_orders_details();
            $importOrderDetail->import_order_id = $importOrder->id;
            $importOrderDetail->product_id = $product->id;
            $importOrderDetail->quantity = $request->quantity;
            $importOrderDetail->price = $request->price;
            $importOrderDetail->save();

            // Update product quantity
            $product->quantity += $request->quantity;
            $product->save();

            // Update total quantity of the import order
            $importOrder->total_quantity += $request->quantity;
            $importOrder->save();

            return response()->json(['message' => 'Nhập kho thành công']);
            // }
            // else {
            //     return response()->json(['message' => ''], 404);
            // }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => 'Hỏng rồi! Khôn lên'
            ]);
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
    public function update(Request $request, Import_orders $importOrder)
    {
        // Update import order details
        // if ($request->has('staff_id')) {
        //     // $importOrder->staff_id = $request->staff_id;
        // }
        //cập nhật lại người nhập kho
        $importOrder->staff_id =  $request->user()->id;

        // Update import order detail
        if ($request->has('product_id') && $request->has('quantity') && $request->has('price')) {
            $product = Product::where('id', $request->product_id)->first();
            if ($product) {
                $importOrderDetail = Import_orders_details::where('import_order_id', $importOrder->id)
                                                      ->where('product_id', $product->id)
                                                      ->first();
                if ($importOrderDetail) {
                    $oldQuantity = $importOrderDetail->quantity;

                    // Update import order detail
                    $importOrderDetail->quantity = $request->quantity;
                    $importOrderDetail->price = $request->price;
                    $importOrderDetail->save();

                    // Update product quantity
                    $product->quantity = $product->quantity - $oldQuantity + $request->quantity;
                    $product->save();

                    // Update total quantity of the import order
                    $importOrder->total_quantity = $importOrder->total_quantity - $oldQuantity + $request->quantity;
                }
            }
        }

        $importOrder->save();

        return response()->json(['message' => 'Import order updated successfully']);
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
