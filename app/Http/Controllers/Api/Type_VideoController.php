<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Type_Video;

class Type_VideoController extends Controller
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
        //     'data' => Type_Video::all(),
        // ], 200);
        return Type_Video::all();
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
    public function updateStatus(Request $request, $id)
    {
        try {
            $type_video = Type_Video::findOrFail($id);
            $type_video->update([
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
        $data = $request->only('name', 'status');
        $status = Type_Video::create($data);

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
        return Type_Video::findOrFail($id);
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
            'name.required' => 'Tên không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name', 'status');
        $user = Type_Video::findOrFail($id);
        $status = $user->update($data);
        // $status = Type_Video::create($data);

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
        $Type_Video = Type_Video::findOrFail($id);
        $Type_Video->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
