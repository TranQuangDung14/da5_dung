<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category_product;
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
    public function index()
    {
        //
        // return product::all();

        // $baseUrl = env('APP_URL') . '/';
        $product = Product::with([
            'category',
            'images' => function ($query) {
                $query->select('image', 'product_id')->orderBy('product_id')->distinct();
            },
        ])
            ->select(['id', 'name','quantity','default_price', 'category_id'])
            ->orderBy('id', 'desc');
        return response()->json([

            // // Danh sách sản phẩm
            'all_product' => $product->get(),
                'product'=>$product->limit(5)->get(),
                'featured_products'=>$product->limit(4)->get(),
            // danh mục sản phẩm
            'category' => Category_product::select('id', 'name')->where('status', 1)->get(),
            // giới hạn danh mục hiển thị
            'category_limit' => Category_product::select('id', 'name')->where('status', 1)->limit(4)->get(),
            // 'product_by_cate'=> $product->limit(10)->get(),
            // đếm số lượng sản phẩm
            'count_product' => Product::count(),
        ], 200);
    }
    public function show_product_by_category(Request $request)
    {
        // $category = $request->category;
        $baseUrl = env('APP_URL') . '/';
        return response()->json([
            // Hiển thị sản phẩm theo danh mục
            // id =1
            'show_by_cate_product_1' => Product::select([
                '*',
                DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")
            ])
                ->where('category_id', 1)
                ->limit(6)
                ->get(),

            'show_by_cate_product_2' => Product::select([
                '*',
                DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")
            ])
                ->where('category_id', 2)
                ->limit(6)
                ->get(),

            'show_by_cate_product_3' => Product::select([
                '*',
                DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")
            ])
                ->where('category_id', 3)
                ->limit(6)
                ->get(),
            'show_by_cate_product_4' => Product::select([
                '*',
                DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")
            ])
                ->where('category_id', 4)
                ->limit(6)
                ->get(),
        ], 200);
    }


    // public function testleftjion(){
    //     return response()->json([

    //         'users' => DB::table('da5_product')
    //             ->leftJoin('da5_category_product', 'da5_category_product.id', '=', 'da5_product.category_id')
    //             ->select('da5_category_product.*','da5_product.name as name_product','da5_product.id','da5_product.category_id')
    //             ->get(),
    //     ],200);
    // }
    //danh sách video
    public function video()
    {
        return response()->json([
            'video' => Video::select('*')->where('status', 1)->get(),
            'type_video' => Type_Video::select('*')->where('status', 1)->get(),

        ], 200);
    }

    // danh mục video
    public function cate_video()
    {
        return response()->json([
            'cate_video' => Type_Video::select('*')->where('status', 1)->get(),

        ], 200);
    }

    // danh mục bài viết
    public function cate_posts()
    {
        return response()->json([
            'cate_posts' => Type_Posts::select('*')->where('status', 1)->get(),

        ], 200);
    }
    // 'posts'=> DB::table('da5_posts')
    //         ->Join('da5_type_posts','da5_posts.type_post_id','=','da5_type_posts.id')
    //         ->Join('users','da5_posts.staff_id','=','users.id')
    //         ->select('da5_posts.*','da5_type_posts.name','users.name as name_user')
    //         ->where('da5_type_posts.status',1)
    //         ->get(),
    // bài viết
    public function posts()
    {

        $baseUrl = env('APP_URL') . '/';
        return response()->json([

            // 'posts' => Posts::select([
            //     '*',
            //     DB::raw("CONCAT('$baseUrl','storage/', da5_posts.image) as img_src")
            // ])
            //     ->where('status', 1)->get(),
            'posts'=> DB::table('da5_posts')
            ->Join('da5_type_posts','da5_posts.type_post_id','=','da5_type_posts.id')
            ->Join('users','da5_posts.staff_id','=','users.id')
            ->select('da5_posts.*','da5_type_posts.name','users.name as name_user')
            ->where('da5_type_posts.status',1)
            ->get(),
            'type_posts' => Type_Posts::select('*')
                ->where('status', 1)
                ->get(),

            'featured_post'=>Posts::orderBy('id', 'desc')->first(),
            // bài viết bên trang chủ
            'posts_index' => Posts::select([
                '*',
                DB::raw("CONCAT('$baseUrl','storage/', da5_posts.image) as img_src")
            ])
                ->where('status', 1)
                ->limit(5)
                ->orderBy('id','desc')
                ->get(),

        ], 200);
    }

    public function statistical()
    {
        try {

        } catch (\Exception $e) {
            dd($e);
        }
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
        // $product= Product::findOrFail($id);
        // $category = Category_product::where('order_id','=',$id)->get();
        // return Product::findOrFail($id);
        // dd('test');
        // $baseUrl = env('APP_URL') . '/';
        $product = Product::with([
            'category',
            'images' => function ($query) {
                $query->select('image', 'product_id')->orderBy('product_id')->distinct();
            },
        ])
            ->select(['id', 'name','quantity','default_price', 'category_id','description','tech_specs'])
            // ->where()
            ->orderBy('id', 'desc')
            ->findOrFail($id);
            return response()->json([
                $product
            ], 200);
        // return Product::select(['*', DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")])->findOrFail($id);
        // return response()->json([

        //     'data'=>DB::table('da5_product')
        //     ->Join('da5_category_product', 'da5_category_product.id', '=', 'da5_product.category_id')
        //     ->select(['da5_product.*', 'da5_category_product.name as name_category', DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")])
        //     // ->select()
        //     ->first($id),
        // ]);
    }
    public function show_posts($id)
    {
        //
        // return Product::findOrFail($id);
        // $baseUrl = env('APP_URL') . '/';
        // return Posts::select(['*', DB::raw("CONCAT('$baseUrl','storage/', da5_posts.image) as img_src")])->findOrFail($id);
      return response()->json([
            'posts'=> DB::table('da5_posts')
            ->Join('da5_type_posts','da5_posts.type_post_id','=','da5_type_posts.id')
            ->Join('users','da5_posts.staff_id','=','users.id')
            ->select('da5_posts.*','da5_type_posts.name','users.name as name_user','users.avatar')
            // ->where('da5_type_posts.status',1)
            ->where('da5_posts.id',$id)
            ->get(),
        ], 200);
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
