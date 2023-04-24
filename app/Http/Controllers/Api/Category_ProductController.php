<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Category_product;
use App\Models\Product_Supplier;
use App\Models\Info_Supplier;
use Illuminate\Support\Facades\DB;

class Category_ProductController extends Controller
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
            // 'supplier'=>Info_Supplier::where('status',1)->select('id','name')->get(),
            // 'category_product' => DB::table('da5_category_product')
            //                     ->leftJoin('da5_info_supplier','da5_category_product.product_supplier_id','=','da5_info_supplier.id')
            //                     ->leftJoin('da5_status','da5_category_product.status','=','da5_status.id')
            //                     ->select('da5_category_product.*','da5_info_supplier.name as name_supplier','da5_status.name_status')
            //                     ->orderBy('id', 'desc')
            //                     ->get(),
            'category' =>Category_product::where('status',1)->get()

        ], 200);
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

        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name', 'description','status');
        $status = Category_product::create($data);

        if ($status)
        {
            // return response()->json([
            //     'messege' => 'Thêm thành công!',
            // ], 201);
            return $data;
        } else {
            return response()->json([
                'messege' => 'Thêm thất bại!',
            ], 400);
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
        return Category_product::findOrFail($id);
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
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name', 'description','status');
        $user = Category_product::findOrFail($id);
        $status = $user->update($data);
        // $status = Category_product::create($data);

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
        $Category_product = Category_product::findOrFail($id);
        $Category_product->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
