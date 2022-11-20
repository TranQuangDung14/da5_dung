<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Product_Supplier;

class Product_SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return response()->json([
        //     'messege' => 'day la bản test db!',
        //     'data' => Product_Supplier::all(),
        // ], 200);
        return Product_Supplier::all();
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
            'amount' => 'required',
            'weight' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'amount.required' => 'số lượng không được phép trống!',
            'weight.required' => 'Cân nặng không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('info_supplier_id', 'name', 'amount','weight','price','description','status');
        $status = Product_Supplier::create($data);

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
        return Product_Supplier::findOrFail($id);
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
            'amount' => 'required',
            'weight' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'amount.required' => 'số lượng không được phép trống!',
            'weight.required' => 'Cân nặng không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('info_supplier_id', 'name', 'amount','weight','price','description','status');
        $user = Product_Supplier::findOrFail($id);
        $status = $user->update($data);
        // $status = Product_Supplier::create($data);

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
        $Product_Supplier = Product_Supplier::findOrFail($id);
        $Product_Supplier->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
