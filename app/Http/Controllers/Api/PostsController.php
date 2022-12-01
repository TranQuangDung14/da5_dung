<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Type_Posts;
use Illuminate\Support\Facades\DB;

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
        return response()->json([
            // 'messege' => 'day la bản test db!',
            'posts_all' => Posts::all(),
            'type_post' =>Type_Posts::all(),
            'posts'=> DB::table('da5_posts')
            ->Join('da5_type_posts','da5_posts.type_post_id','=','da5_type_posts.id')
            ->select('da5_posts.*','da5_type_posts.name')
            ->where('da5_type_posts.status',1)
            ->get(),
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
        $data = $request->only('type_post_id', 'title', 'staff_id','content','status');
        $status = Posts::create($data);

        if ($status)
        {
            // return response()->json([
            //     'messege' => 'Thêm thành công!',
            // ], 201);
            return $data;
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
        return Posts::findOrFail($id);
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
        $data = $request->only('type_post_id', 'title', 'staff_id','content','status');
        $user = Posts::findOrFail($id);
        // $status = Posts::create($data);
        $status = $user->update($data);
        // $status = Posts::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Sửa thành công !',
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
