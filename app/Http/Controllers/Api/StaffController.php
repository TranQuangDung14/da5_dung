<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Staff;


class StaffController extends Controller
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
            'messege' => 'day la bang nhan vien!',
            'data' => Staff::all(),
        ], 200);
        // $customer= Customer::get();
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
            'date_of_birth' => 'required',
            'sex' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'date_of_birth.required' => 'icon không được phép trống!',
            'sex.required' => 'status không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name','date_of_birth','sex','number_phone','email','adress','possion','department');
        $status = Staff::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Thêm thành công nhân viên!',
            ], 201);
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

        $input = $request->all();
        // return response()->json([
        //     'messege' => $input
        // ], 200);
        $rules = array(
            'name' => 'required',
            'date_of_birth' => 'required',
            'sex' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'date_of_birth.required' => 'icon không được phép trống!',
            'sex.required' => 'status không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name','date_of_birth','sex','number_phone','email','adress','possion','department');
        $user = Staff::findOrFail($id);
        $status = $user->update($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Cập nhật thành công!',
            ], 200);
        } else {
            return response()->json([
                'messege' => 'Cập nhật thất bại!',
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
        $Staff = Staff::findOrFail($id);
        $Staff->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
