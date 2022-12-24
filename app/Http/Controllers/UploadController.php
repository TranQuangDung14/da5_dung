<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{

    // file này chỉ để lưu hàm upload 
    //
    public function upload(Request $request){
        $image =$request->file('image');
        if($request->hasFile('image')){
            $new_name =rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/images'),$new_name);
            return response()->json($new_name);
        }else{
            return response()->json('ảnh trống');
        }

    }
}
