<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'messege' => 'Succsess get list users',
            'data' => User::all(),
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($request->password);
        $status = User::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Thêm thành công tài khoản!',
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|unique:users,email,'.$id,
            'password' => 'required|string|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        $user = User::findOrFail($id);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($request->password);

        $status = $user->update($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Succsess edit user',
            ], 200);
        } else {
            return response()->json([
                'messege' => 'Register user not success',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'messege' => 'Succsess delete user',
        ], 200);
    }

}
