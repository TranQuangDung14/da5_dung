<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Dotenv\Validator;
use Illuminate\Http\Request;

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
            if ($request->hasFile('image')) {
                $result = ($request->file('image')->store('image/posts'));
                $banner->image =  (!empty($request->image = $result)) ? $request->image : null;
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

            /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function slides()
    {
        $banner = Banner::orderBy('id','desc')->first();
        // $banner->delete();
        return response()->json([
            'banner' => $banner,
        ], 200);
    }
}
