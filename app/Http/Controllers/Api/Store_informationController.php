<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store_information;
use Illuminate\Http\Request;

class Store_informationController extends Controller
{
    public function index()
    {
        $store_information = Store_information::get();
        return response()->json([
            'store_information' => $store_information,
        ], 200);
    }

          /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $store_information = new Store_information();
            $store_information->map = $request->map;
            $store_information->number_phone = $request->number_phone;
            $store_information->email = $request->email;
            $store_information->open_time = $request->open_time;
            $store_information->address = $request->address;
            $store_information->save();

            return response()->json([
                'message' => 'thêm mới thành công!',
                'banner' => $store_information,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                dd($e),
                'message' => 'Thêm thất bại!',
            ], 200);
        }
    }
    public function show($id)
    {
        return Store_information::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $store_information = Store_information::findOrFail($id);
        $store_information->map = $request->map;
        $store_information->number_phone = $request->number_phone;
        $store_information->email = $request->email;
        $store_information->open_time = $request->open_time;
        $store_information->address = $request->address;
        $store_information->save();

        return response()->json([
            'messege' => 'Cập nhật thành công!',
        ], 200);
    }

    public function destroy($id)
    {
        $store_information = Store_information::findOrFail($id);
        $store_information->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
