<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::get();
        // $banner->delete();
        return response()->json([
            'banner' => $banner,
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
            $banner = new Banner();
            // if ($request->hasFile('image')) {
            //     $result = ($request->file('image')->store('image/posts'));
            //     $banner->image =  (!empty($request->image = $result)) ? $request->image : null;
            // }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('image/posts');
                $banner->image = $imagePath;
            }
            $banner->ordinal = $request->ordinal;
            $banner->save();

            return response()->json([
                'message' => 'thêm mới thành công!',
                'banner' => $banner,
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
        // dd('dddd');
        try {
            return Banner::findOrFail($id);
        } catch (\Exception $e) {
            dd($e);
        }

    }
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('image/posts');
            Storage::delete($banner->image);
            $banner->image = $imagePath;
        }
        $banner->ordinal = $request->ordinal;
        $banner->save();

        return response()->json([
            'messege' => 'Cập nhật thành công!',
        ], 200);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::delete($banner->image);
        $banner->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function slides()
    {
        $banner_1 = Banner::where('ordinal',1)->orderBy('id','desc')->first();// slide chính
        $banner_2 = Banner::where('ordinal',2)->orderBy('id','desc')->first();// slide quảng cáo  trái
        $banner_3 = Banner::where('ordinal',3)->orderBy('id','desc')->first();// slide quảng cáo phải
        $banner_4 = Banner::where('ordinal',4)->orderBy('id','desc')->first();// slide logo
        // $banner->delete();
        return response()->json([
            'banner_1' => $banner_1,
            'banner_2' => $banner_2,
            'banner_3' => $banner_3,
            'banner_4' => $banner_4,
        ], 200);
    }
}
