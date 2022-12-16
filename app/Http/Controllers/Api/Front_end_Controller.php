<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Type_Posts;
use App\Models\Type_Video;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class Front_end_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  danh sách sản phẩm
    public function index(Request $request)
    {
        //
        // return product::all();
        $category=$request->category;
        $baseUrl = env('APP_URL') . '/';
        return response()->json([
            'product' => Product::where('status', 1)
                ->select([
                    'id',
                    'name as name_cate',
                    DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")
                ])
                ->limit(5)
                ->get(),
                // Danh sách sản phẩm
                'product_sale'=>Product::where('category_id',$category)->get(),
        ], 200);
    }

    //danh sách video
    public function video(){
        return response()->json([
            'video' => Video::select('*')->where('status',1)->get(),
            'type_video' => Type_Video::select('*')->where('status',1)->get(),
            
        ], 200);
    }

    // danh mục video
    public function cate_video(){
        return response()->json([
            'cate_video' => Type_Video::select('*')->where('status',1)->get(),
            
        ], 200);
    }

    // danh mục bài viết
    public function cate_posts(){
        return response()->json([
            'cate_posts' => Type_Posts::select('*')->where('status',1)->get(),
            
        ], 200);
    }
    // bài viết
    public function posts(){

        $baseUrl = env('APP_URL') . '/';
        return response()->json([
           
            'posts' => Posts::select([
                '*',
                DB::raw("CONCAT('$baseUrl','storage/', da5_posts.image) as img_src")
            ])->where('status',1)->get(),
            'type_posts' => Type_Posts::select('*')->where('status',1)->get(),
       
        ], 200);
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
        //
    }

    // chi tiết sản phẩm
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // return Product::findOrFail($id);
        $baseUrl = env('APP_URL') . '/';
        return Product::select(['*', DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")])->findOrFail($id);

    }
    public function show_posts($id)
    {
        //
        // return Product::findOrFail($id);
        $baseUrl = env('APP_URL') . '/';
        return Posts::select(['*',DB::raw("CONCAT('$baseUrl','storage/', da5_posts.image) as img_src")])->findOrFail($id);

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
