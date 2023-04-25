<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // return response()->json([
        //     'messege' => 'day !',
        //     'data' => Customer::all(),
        // ], 200);
        return Customer::all();
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
        // $input = $request->all();
        // $rules = array(
        //     'name' => 'required',
        //     'date_of_birth' => 'required',
        //     'sex' => 'required',
        // );
        // $messages = array(
        //     'name.required' => 'Tên  không được phép trống!',
        //     'date_of_birth.required' => 'ngày sinh không được phép trống!',
        //     'sex.required' => 'giới tính không được phép trống!',
        // );
        // $validator = Validator::make($input, $rules, $messages);
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 404);
        // }
        $data = $request->only('user_id','order_id', 'name', 'date_of_birth','sex','number_phone','email','adress');
        $status = Customer::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Thêm thành công!',
                'data'=> Customer::all()
            ], 201);
            // return $data;
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
        return Customer::findOrFail($id);
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
            'date_of_birth' => 'required',
            'sex' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'date_of_birth.required' => 'ngày sinh không được phép trống!',
            'sex.required' => 'giới tính không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('id_user', 'name', 'date_of_birth','sex','number_phone','email','adress');
        $user = Customer::findOrFail($id);
        $status = $user->update($data);
        // $status = testdb::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Sửa thành công !',
                Customer::all()
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
        $Customer = Customer::findOrFail($id);
        $Customer->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
