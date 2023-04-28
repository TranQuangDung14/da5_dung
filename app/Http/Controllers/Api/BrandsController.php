<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Brands::all();
        } catch (\Exception $e) {
           return response()->json([
            // dd($e),
            'message' => 'Mở thất bại!',
        ], 200);
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
        $input = $request->all();
        $rules = array(
            'name' => 'required',

        );
        $messages = array(
            'name.required' => 'Tên thương hiệu không được phép trống!',

        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        try {
            $brands = new Brands();
            $brands->name = $request->name;
            $brands->description =  (!empty($request->description)) ? $request->description : null;
            $brands->save();

            return response()->json([
                'message' => 'thêm mới thành công!',
                'brands' => $brands,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                dd($e),
                'message' => 'Thêm thất bại!',
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
        $brands = Brands::findOrFail($id);
        return response()->json([
            'brands'=>$brands
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        try {
            $brands = Brands::findOrFail($id);
            $brands->name = $request->name;
            $brands->description =  (!empty($request->description)) ? $request->description : null;
            $brands->update();
            return response()->json([
                'message' => 'Cập nhật thương hiệu thành công!',
                'brands' => $brands,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                dd($e),
                'message' => 'Cập nhật thương hiệu thất bại!',
            ], 200);
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
        $brands = Brands::findOrFail($id);
        $brands->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
