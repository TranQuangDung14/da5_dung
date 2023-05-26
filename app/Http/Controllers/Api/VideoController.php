<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type_Video;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json([
            // 'messege' => 'day la bản test db!',
            // 'data' => Video::all(),
            'video' => Video::all(),
            'type_video' => Type_Video::all(),
            // 'video'=> DB::table('da5_video')
            // ->Join('da5_type_video','da5_video.type_video_id','=','da5_type_video.id')
            // ->select('da5_video.*','da5_type_video.name')
            // ->where('da5_type_video.status',1)
            // ->get(),
        ], 200);
        // return Video::all();
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
            $video = Video::findOrFail($id);
            $video->update([
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
            'title' => 'required',
        );
        $messages = array(
            'title.required' => 'Tiêu đề không được phép trống!',

        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        try {
            // $staffId                       =   $request->user()->id;
            $video = new Video();
            $video->staff_id               =   $request->user()->id;
            $video->type_video_id          =   (!empty($request->type_video_id)) ? $request->type_video_id : null;
            $video->title                  =   (!empty($request->title)) ? $request->title : null;
            $video->hashtag                =   (!empty($request->hashtag)) ? $request->hashtag : null;
            $video->video                  =   (!empty($request->video)) ? $request->video : null;
            $replaced                      =   Str::replace('https://www.youtube.com/watch?v=', '', $video->video);
            $array_id_video                =   array_map('strval', explode('&', $replaced));
            $video->link_id                =   $array_id_video[0];
            $video->description            =   (!empty($request->description)) ? $request->description : null;
            $video->save();

            return response()->json([
                'messege' => 'Thêm thành công!',
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'messege' => 'Thêm thất bại!',
            ], 400);
        }

        // $data = $request->only('title','staff_id','hashtag', 'type_video_id', 'video','link_id','description','status');
        // $status = Video::create($data);
        // if ($status)
        // {
        //     // return response()->json([
        //     //     'messege' => 'Thêm thành công!',
        //     // ], 201);
        //     return $data;
        // } else {
        //     return response()->json([
        //         'messege' => 'Thêm thất bại!',
        //     ], 400);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Video::findOrFail($id);
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
            'title' => 'required',

        );
        $messages = array(
            'name.required' => 'Tiêu đề không được phép trống!',

        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        // $data = $request->only('title', 'staff_id', 'hashtag', 'type_video_id', 'video', 'description', 'status');
        $video = Video::findOrFail($id);
        $video->staff_id               =   $request->user()->id;
        $video->type_video_id          =   (!empty($request->type_video_id)) ? $request->type_video_id : null;
        $video->title                  =   (!empty($request->title)) ? $request->title : null;
        $video->hashtag                =   (!empty($request->hashtag)) ? $request->hashtag : null;
        $video->video                  =   (!empty($request->video)) ? $request->video : null;
        $replaced                      =   Str::replace('https://www.youtube.com/watch?v=', '', $video->video);
        $array_id_video                =   array_map('strval', explode('&', $replaced));
        $video->link_id                =   $array_id_video[0];
        $video->description            =   (!empty($request->description)) ? $request->description : null;
        $video->save();
        // $status = $user->update($data);
        // $status = Video::create($data);
        return response()->json([
            'messege' => 'Cập nhật thành công!',
        ], 201);
        // if ($status) {
        //     return response()->json([
        //         'messege' => 'Sửa thành công !',
        //     ], 201);
        // } else {
        //     return response()->json([
        //         'messege' => 'Sửa thất bại!',
        //     ], 400);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Video = Video::findOrFail($id);
        $Video->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
