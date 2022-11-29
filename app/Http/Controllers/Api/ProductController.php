<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Category_product;
use App\Models\Info_Supplier;
use App\Models\Product_Supplier;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
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
            'category_product'=>Category_product::where('status',1)->select('id','name')->get(),
            // 'supplier'=>Info_Supplier::where('status',1)->select('id','name')->get(),
            'product' =>  DB::table('da5_product')
                                ->Join('da5_warehouse','da5_product.id','=','da5_warehouse.product_id')
                                ->select('da5_product.*','da5_warehouse.amount')
                                ->where('da5_product.status',1)
                                ->get(),

            'product_all' =>Product::all(),
        ], 200);
        // return Product::all();
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
        $input = $request->all();
        $rules = array(
            'name' => 'required',
            'default_price' => 'required',
            'price' => 'required',
            'amount'=>'required'
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'default_price.required' => 'Giá tiền mặc định không được phép trống!',
            'price.required' => 'Giá tiền không được phép trống!',
            'amount.required' => 'Số lượng không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        
        DB::beginTransaction();
        try{  

            $product = new Product();
            $product->category_id =  (!empty($request->category_id)) ? $request->category_id : null;
            $product->name = $request->name;
            $product->default_price = $request->default_price;
            $product->price = $request->price;
            $product->image =  (!empty($request->image)) ? $request->image : null;
            $product->description =  (!empty($request->description)) ? $request->description : null;
            $product->save();

            $warehouse = new Warehouse();
            $warehouse->product_id = $product->id;
            // $warehouse->product_supplier_id = $request->product_supplier_id;
            $warehouse->amount = $request->amount;
            $warehouse->save();
            DB::commit();
            // return 'thành công!';
        } 
        catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return 'thất bại';
            // return redirect()->back();
        }


        // if ($status)
        // {
        //     // return response()->json([
        //     //     'messege' => 'Thêm thành công!',
        //     // ], 201);
        //     return $data;
        // } else {
        //     return response()->json([
        //         'messege' => 'Thêm thất bại!',
        //     ], 400);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::findOrFail($id);
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
        $input = $request->all();
        $rules = array(
            'name' => 'required',
            'default_price' => 'required',
            'price' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'default_price.required' => 'Giá tiền mặc định không được phép trống!',
            'price.required' => 'Giá tiền không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('category_id', 'name', 'default_price','price','image','description','status');
        $user = Product::findOrFail($id);
        $status = $user->update($data);
        // $status = Product::create($data);

        if ($status)
        {
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
        $Product = Product::findOrFail($id);
        $Product->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
