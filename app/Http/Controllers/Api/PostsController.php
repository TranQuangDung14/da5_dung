<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Type_Posts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $baseUrl = env('APP_URL') . '/';
        return response()->json([
            // 'messege' => 'day la bản test db!',
            'posts_all' => Posts::all(),
            'type_post' => Type_Posts::all(),
            'posts' => DB::table('da5_posts')
                ->Join('da5_type_posts', 'da5_posts.type_post_id', '=', 'da5_type_posts.id')
                ->Join('users', 'da5_posts.staff_id', '=', 'users.id')
                ->select('da5_posts.*', 'da5_type_posts.name', 'users.name as name_user')
                ->where('da5_type_posts.status', 1)
                ->get(),
            // 'user' =>User::where('role','staff')->get(),
            // 'image_posts'=>Posts::select
            // 'image_posts'=> Posts::select(['*', DB::raw("CONCAT('$baseUrl','storage/', da5_posts.image) as img_src")])->get(),
        ], 200);
        // return Posts::all();

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
            $post = Posts::findOrFail($id);
            $post->update([
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
            'content' => 'required',

        );
        $messages = array(
            'title.required' => 'Tiêu đề không được phép trống!',
            'content.required' => 'Nội dung không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        try {
            // Lấy id của nhân viên đăng nhập
            $staffId = $request->user()->id;
            $posts = new Posts();
            $posts->type_post_id =  (!empty($request->type_post_id)) ? $request->type_post_id : null;
            $posts->title = $request->title;
            $posts->staff_id =  $staffId;
            $posts->content = $request->content;
            $posts->hashtag = $request->hashtag;
            if ($request->hasFile('image')) {
                $result = ($request->file('image')->store('image/posts'));
                $posts->image =  (!empty($request->image = $result)) ? $request->image : null;
            }
            $posts->save();
            return response()->json([
                'messege' => $posts,
            ], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'messege' => 'thất bại!'
            ], 200);
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
        return Posts::findOrFail($id);

        // return response()->json([
        //     'posts'=> DB::table('da5_posts')
        //     ->Join('da5_type_posts','da5_posts.type_post_id','=','da5_type_posts.id')
        //     ->Join('users','da5_posts.staff_id','=','users.id')
        //     ->select('da5_posts.*','da5_type_posts.name','users.name as name_user')
        //     // ->where('da5_type_posts.status',1)
        //     ->where('da5_posts.id',$id)
        //     ->get(),
        // ], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //

    // }

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
            'content' => 'required',

        );
        $messages = array(
            'title.required' => 'Tiêu đề không được phép trống!',
            'content.required' => 'Nội dung không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        $posts = Posts::findOrFail($id);
        $posts->type_post_id =  (!empty($request->type_post_id)) ? $request->type_post_id : null;
        $posts->title = $request->title;
        $posts->staff_id =  (!empty($request->staff_id)) ? $request->staff_id : null;
        $posts->content = $request->content;
        $posts->hashtag = $request->hashtag;
        if ($request->hasFile('image')) {
            $result = ($request->file('image')->store('image/posts'));
            Storage::delete($posts->image);
            $posts->image =  (!empty($request->image = $result)) ? $request->image : null;
        }
        $posts->update();
        if ($posts) {
            return response()->json([
                'messege' => $posts,
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
        $Posts = Posts::findOrFail($id);
        $Posts->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
