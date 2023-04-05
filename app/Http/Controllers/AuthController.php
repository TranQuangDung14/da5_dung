<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
// use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if(!$user|| !Hash::check($request->password, $user->password,[])){
            return response()->json(
                [
                    // 'message'=>"Lỗi đăng nhập (login)!"
                    'Thông tin tài khoản mật khẩu không chính xác!'
                ],
                401
            );
        }
        $token =$user->createToken('authToken')->plainTextToken;

        return
        [
            'access_token'=>$token,
        ];
    }


    public function register(Request $request)
    {
        $messages =[
            'email.email'=>"Error email",
            'email.required'=>"Vui lòng nhập! ",
            'password.required'=>"Vui lòng nhập mật khẩu! ",
            'email.unique' => 'Địa chỉ email đã được sử dụng, vui lòng nhập địa chỉ email khác',
        ];
        $validate = Validator::make($request->all(),[
            // 'email'=>'email|required',
            // 'loi'
            'email' => [
                'email',
                'required',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('email', $request->email);
                }),
            ],
            'password'=>'required',

        ],$messages );
        if($validate->fails()){
            return response()->json(
                [
                    'message'=>$validate->errors()
                ],
                422
            );
        }
        User::create(
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]
        );
        // return User::all();
        return response()->json(
            [
                'message'=>"Tạo tài khoản thành công!",
                'tesst'=>"Tạo tài khoản thành công!"
            ],
            201
        );
        // return response()->json([

    }
    //
    public function user(Request $request)
    {
        # code...
       return $request->user();
    }
    public function logout()
    {
        // return "logout!";
        // Revoke all tokens...
        // auth()->user()->tokens()->delete();
    auth()->user()->tokens()->delete();
        // Revoke the token that was used to authenticate the current request...
        // auth()->user()->currentAccessToken()->delete();

        // // Revoke a specific token...
        // $user->tokens()->where('id', $tokenId)->delete();

        return response()->json(
            [
                'message'=>"Đăng xuất thành công!"
            ],
            201
        );
    }
}
