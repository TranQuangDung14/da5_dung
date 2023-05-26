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
            'category' =>Category_product::get()

        ], 200);
    }


    // public function updatestatus(Request $request)
    // {
    //     try {
    //         if ($request->status == 'on') {
    //             $status = 1;
    //         } else {
    //             $status = 0;
    //         }

    //         $category = Category_product::find($request->id);
    //         $category->status = $status;
    //         $category->save();

    //         return response()->json($category);
    //     } catch (\Exception $e) {

    //         // Toastr::error('Operation Failed', 'Failed');
    //         return redirect()->back();
    //     }

    // }

    public function updateStatus(Request $request, $id)
    {
        try {
        $categoryProduct = Category_product::findOrFail($id);
        $categoryProduct->update([
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Cập nhật trạng thái thành công']);
    } catch (\Exception $e) {

        // Toastr::error('Operation Failed', 'Failed');
        return response()->json(['message' => 'Cập nhật trạng thái thất bại']);
    }

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
