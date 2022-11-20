<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Info_Supplier;

class Info_SupplierController extends Controller
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
        //     'data' => Info_Supplier::all(),
        // ], 200);
        return Info_Supplier::all();
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
            'email'=>'email'
        );
        $messages = array(
            'name.required' => 'Tên không được phép trống!',
            'email.email' => 'email không đúng định dạng!',

        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name', 'email', 'adress','number_phone','sectors','status');
        $status = Info_Supplier::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Thêm thành công!',
                'data'=>Info_Supplier::all()
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
        return Info_Supplier::findOrFail($id);
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
            'email'=>'email'
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'email.email' => 'email không đúng định dạng!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name', 'email','adress','number_phone','sectors','status');
        $user = Info_Supplier::findOrFail($id);
        $status = $user->update($data);
        // $status = Info_Supplier::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Sửa thành công !',
                'info_supplier'=>$data
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
        $info_Supplier = Info_Supplier::findOrFail($id);
        $info_Supplier->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
