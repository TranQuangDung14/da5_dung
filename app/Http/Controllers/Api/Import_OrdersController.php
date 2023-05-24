<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Import_orders;
use App\Models\Import_orders_details;
use App\Models\Info_Supplier;
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
                'import_order_detail'=>Import_orders_details::get(),
                'product'=>  Product::where('status', 1)->select('id', 'name as name_product')->get(),
                'supplier'=> Info_Supplier::select('id', 'name as name_supplier')->get(),
                'import_order' => DB::table('da5_import_orders')
                    ->leftJoin('da5_import_orders_detail', 'da5_import_orders_detail.import_order_id', '=', 'da5_import_orders.id')
                    ->leftJoin('da5_product', 'da5_import_orders_detail.product_id', '=', 'da5_product.id')
                    ->leftJoin('da5_info_supplier', 'da5_import_orders.supplier_id', '=', 'da5_info_supplier.id')
                    ->leftJoin('users','da5_import_orders.staff_id','=','users.id')
                    ->select('da5_import_orders.*', 'da5_import_orders_detail.*', 'da5_product.name as name_product','users.name as name_user','da5_info_supplier.name as name_supplier')
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
        DB::beginTransaction();
        try {
            $importOrder = new Import_orders();
            $importOrder->staff_id =  $request->user()->id;
            $importOrder->supplier_id =  $request->supplier_id;
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
            $importOrder->total_cost = ($request->quantity)*($request->price);
            $importOrder->save();
            DB::commit();
            return response()->json(['message' => 'Nhập kho thành công']);

        } catch (\Exception $e) {
            //throw $th;
            DB::rollback();
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
        return response()->json([
            'import_order' => DB::table('da5_import_orders')
                    ->leftJoin('da5_import_orders_detail', 'da5_import_orders_detail.import_order_id', '=', 'da5_import_orders.id')
                    ->select('da5_import_orders.*', 'da5_import_orders_detail.*')
                    ->where('da5_import_orders.id', $id)
                    ->first(),
        ]);
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

        DB::beginTransaction();
        try {
          //cập nhật lại người nhập kho
        $importOrder->staff_id =  $request->user()->id;
        $importOrder->supplier_id =  $request->supplier_id;

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
                    $importOrder->total_cost = ($request->quantity)*($request->price);
                }
            }
        }

        $importOrder->save();
        DB::commit();
        return response()->json([
            'message' => 'Cập nhật thành công!'
        ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Cập nhật thất bại!'
            ]);
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
    public function destroy(Import_orders $importOrder)
    {
        // dd($importOrder);
        // Decrease the product quantity
        // dd($importOrder->import_orders_details);
        foreach ($importOrder->import_orders_details as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                $product->quantity -= $detail->quantity;
                $product->save();
            }
        }
        // Delete import order details
        $importOrder->import_orders_details()->delete();
        // Delete import order
        $importOrder->delete();
        return response()->json(['message' => 'Xóa bản ghi nhập kho thành công!']);
    }
}
