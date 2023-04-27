<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Staff;
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
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password, [])) {
            return response()->json(
                [
                    // 'message'=>"Lỗi đăng nhập (login)!"
                    'Thông tin tài khoản mật khẩu không chính xác!'
                ],
                401
            );
        }
        $token = $user->createToken('authToken')->plainTextToken;

        return
            [
                'access_token' => $token,
            ];
    }


    // public function register(Request $request)
    // {
    //     $messages =[
    //         'email.email'=>"Chưa đúng định dạng email",
    //         'email.required'=>"Vui lòng nhập! ",
    //         'password.required'=>"Vui lòng nhập mật khẩu! ",
    //         'email.unique' => 'Địa chỉ email đã được sử dụng, vui lòng nhập địa chỉ email khác',
    //         'role.required'=>'Chưa nhập kìa bạn'
    //     ];
    //     $validate = Validator::make($request->all(),[
    //         // 'email'=>'email|required',
    //         // 'loi'
    //         'email' => [
    //             'email',
    //             'required',
    //             Rule::unique('users')->where(function ($query) use ($request) {
    //                 return $query->where('email', $request->email);
    //             }),
    //         ],
    //         'password'=>'required',
    //         'role' => 'required|in:customer,employee',
    //     ],$messages );
    //     if($validate->fails()){
    //         return response()->json(
    //             [
    //                 'message'=>$validate->errors()
    //             ],
    //             400
    //         );
    //     }
    //     try {
    //         User::create(
    //             [
    //                 'name'=>$request->name,
    //                 'email'=>$request->email,
    //                 'password'=>Hash::make($request->password),
    //                 'role' => $validate['role'],
    //             ]
    //         );
    //         // if ($validate['role'] == 'customer') {
    //         //     $customer = Customer::create([
    //         //         'user_id' => $user->id,
    //         //         'name' => $validate['name'],
    //         //         'date_of_birth' => $validate['date_of_birth'],
    //         //         'sex' => $validate['sex'],
    //         //         'number_phone' => $validate['number_phone'],
    //         //         'address' => $validate['address'],
    //         //     ]);
    //         // }else {
    //         //     $employee = Staff::create([
    //         //         'user_id' => $user->id,
    //         //         'name' => $validate['name'],
    //         //         'date_of_birth' => $validate['date_of_birth'],
    //         //         'sex' => $validate['sex'],
    //         //         'number_phone' => $validate['number_phone'],
    //         //         'address' => $validate['address'],
    //         //         'position' => $validate['position'],
    //         //         'department' => $validate['department'],
    //         //     ]);
    //         // }
    //         return response()->json(
    //             [
    //                 'message'=>"Tạo tài khoản thành công!",
    //                 'tesst'=>"Tạo tài khoản thành công!"
    //             ],
    //             201
    //         );
    //     } catch (\Exception $e) {
    //         //throw $th;
    //         dd($e);
    //         return response()->json(
    //             [
    //                 'message'=>"lỗi gòy!",

    //             ],
    //             201
    //         );
    //     }

    //     // return User::all();

    //     // return response()->json([

    // }


    public function register_customer(Request $request)
    {
        // dd($request->all());
        $messages =[
            'email.email'=>"Chưa đúng định dạng email",
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
            throw new \Exception($validate->errors(), 422);
        }
        try {

            $user = User::create([
                // dd($user->all()),
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role' =>'customer',
            ]);

                $customer = Customer::create([
                    'user_id' => $user->id,
                    'name' => $request->input('name'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'sex' => $request->input('sex'),
                    'number_phone' => $request->input('number_phone'),
                    'address' => $request->input('address'),
                ]);

            return response()->json([
                'message'=>"Tạo tài khoản thành công!",
            ], 201);

        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
    public function register_staff(Request $request)
    {
        $messages =[
            'email.email'=>"Chưa đúng định dạng email",
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
            // 'role' => 'required|in:customer,employee',
        ],$messages );

        try {
            if($validate->fails()){
                throw new \Exception($validate->errors(), 422);
            }

            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role' =>'staff',
            ]);

                $employee = Staff::create([
                    'user_id' => $user->id,
                    'name' => $request->input('name'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'sex' => $request->input('sex'),
                    'number_phone' => $request->input('number_phone'),
                    'address' => $request->input('address'),
                    'position' => $request->input('position'),
                    'department' => $request->input('department'),
                ]);

            return response()->json([
                'message'=>"Tạo tài khoản thành công!",
                'tesst'=>"Tạo tài khoản thành công!"
            ], 201);

        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }


    // public function registerCustomer(Request $request)
    // {
    //     // validate input data
    //     $validatedData = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|string|email|unique:users,email',
    //         'password' => 'required|string|min:6|confirmed',
    //         'date_of_birth' => 'required|date',
    //         'sex' => 'required|string',
    //         'number_phone' => 'required|string',
    //         'address' => 'required|string',
    //     ]);

    //     try {
    //             // create new user
    //     $user = User::create([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'password' => Hash::make($validatedData['password']),
    //         'role' => 'customer',
    //     ]);

    //     // create new customer
    //     $customer = Customer::create([
    //         'user_id' => $user->id,
    //         'name' => $validatedData['name'],
    //         'date_of_birth' => $validatedData['date_of_birth'],
    //         'sex' => $validatedData['sex'],
    //         'number_phone' => $validatedData['number_phone'],
    //         'address' => $validatedData['address'],
    //     ]);
    //     return response()->json([
    //                     'message'=>"Tạo tài khoản thành công!",
    //                     'tesst'=>"Tạo tài khoản thành công!"
    //                 ], 201);
    //     } catch (\Exception $e) {
    //         dd($e);
    //                 return response()->json([
    //                     'message' => $e->getMessage(),
    //                 ], $e->getCode());
    //             }


    // }
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
                'message' => "Đăng xuất thành công!"
            ],
            201
        );
    }
}
