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
    public function customerLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || $user->role !== 'customer' || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Thông tin tài khoản mật khẩu không chính xác!'], 401);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return [
            'access_token' => $token,
        ];
    }
    public function staffLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || $user->role !== 'staff' || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Thông tin tài khoản mật khẩu không chính xác!'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return [
            'access_token' => $token,
        ];
    }

    public function register_customer(Request $request)
    {
        // dd($request->all());
        $messages = [
            'email.email' => "Chưa đúng định dạng email",
            'email.required' => "Vui lòng nhập! ",
            'password.required' => "Vui lòng nhập mật khẩu! ",
            'email.unique' => 'Địa chỉ email đã được sử dụng, vui lòng nhập địa chỉ email khác',
        ];
        $validate = Validator::make($request->all(), [
            // 'email'=>'email|required',
            // 'loi'
            'email' => [
                'email',
                'required',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('email', $request->email);
                }),
            ],
            'password' => 'required',
        ], $messages);

        if ($validate->fails()) {
            throw new \Exception($validate->errors(), 422);
        }
        try {

            $user = User::create([
                // dd($user->all()),
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
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
                'message' => "Tạo tài khoản thành công!",
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
        $messages = [
            'email.email' => "Chưa đúng định dạng email",
            'email.required' => "Vui lòng nhập! ",
            'password.required' => "Vui lòng nhập mật khẩu! ",
            'email.unique' => 'Địa chỉ email đã được sử dụng, vui lòng nhập địa chỉ email khác',
        ];
        $validate = Validator::make($request->all(), [
            // 'email'=>'email|required',
            // 'loi'
            'email' => [
                'email',
                'required',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('email', $request->email);
                }),
            ],
            'password' => 'required',
            // 'role' => 'required|in:customer,employee',
        ], $messages);

        try {
            if ($validate->fails()) {
                throw new \Exception($validate->errors(), 422);
            }

            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'role'          => 'staff',
            ]);

            $employee = Staff::create([
                'user_id'           => $user->id,
                'name'              => $request->input('name'),
                'date_of_birth'     => $request->input('date_of_birth'),
                'sex'               => $request->input('sex'),
                'number_phone'      => $request->input('number_phone'),
                'address'           => $request->input('address'),
                'position'          => $request->input('position'),
                'department'        => $request->input('department'),
            ]);

            return response()->json([
                'message' => "Tạo tài khoản thành công!",
            ], 201);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }


    public function user(Request $request)
    {
        # code...
        return $request->user();
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json([
                'message' => 'Đăng xuất thành công!'
            ], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();
            // $test= $request->user()->id;
            // dd($user);
            if (!$user) {
                return response()->json(['error' => 'Không tìm thấy người dùng được xác thực nào'], 403);
            }
            $validatedData = $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:3',
                'new_confirm_password' => 'same:new_password',
            ]);
            // $user = Auth::user();
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['error' => 'Mật khẩu hiện tại không khớp'], 403);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['message' => 'Mật khẩu đã được thay đổi thành công'], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
