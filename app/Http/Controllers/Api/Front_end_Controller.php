<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Brands;
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
            ->select(['id', 'name', 'quantity', 'default_price', 'category_id'])
            ->orderBy('id', 'desc');
        return response()->json([

            // // Danh sách sản phẩm
            'all_product' => $product->get(),
            'product' => $product->limit(5)->get(),
            'featured_products' => $product->limit(4)->get(),
            'brand'=>Brands::select('id','name')->get(),
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
    // bài viết
    public function posts()
    {
        $baseUrl = env('APP_URL') . '/';
        return response()->json([
            'posts' => DB::table('da5_posts')
                ->Join('da5_type_posts', 'da5_posts.type_post_id', '=', 'da5_type_posts.id')
                ->Join('users', 'da5_posts.staff_id', '=', 'users.id')
                ->select('da5_posts.*', 'da5_type_posts.name', 'users.name as name_user')
                ->where('da5_type_posts.status', 1)
                ->get(),
            'type_posts' => Type_Posts::select('*')
                ->where('status', 1)
                ->get(),

            'featured_post' => Posts::orderBy('id', 'desc')->first(),
            // bài viết bên trang chủ
            'posts_index' => Posts::select([
                '*',
                DB::raw("CONCAT('$baseUrl','storage/', da5_posts.image) as img_src")
            ])
                ->where('status', 1)
                ->limit(5)
                ->orderBy('id', 'desc')
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

    // chi tiết sản phẩm
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with([
            'category',
            'images' => function ($query) {
                $query->select('image', 'product_id')->orderBy('product_id')->distinct();
            },
        ])
            ->select(['id', 'name', 'quantity', 'default_price', 'category_id', 'description', 'tech_specs'])
            // ->where()
            ->orderBy('id', 'desc')
            ->findOrFail($id);
        return response()->json([
            $product
        ], 200);
    }
    public function show_posts($id)
    {
        return response()->json([
            'posts' => DB::table('da5_posts')
                ->Join('da5_type_posts', 'da5_posts.type_post_id', '=', 'da5_type_posts.id')
                ->Join('users', 'da5_posts.staff_id', '=', 'users.id')
                ->select('da5_posts.*', 'da5_type_posts.name', 'users.name as name_user', 'users.avatar')
                // ->where('da5_type_posts.status',1)
                ->where('da5_posts.id', $id)
                ->get(),
        ], 200);
    }


    // Hiển thị sản phẩm theo danh mục
    public function showProductsByCategory($id)
    {
        try {
            $category = Category_product::findOrFail($id);
            $products = $category->products;

            return response()->json($products);
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
        }
    }
    // lọc sản phẩm theo điều kiện
    public function filterProducts(Request $request)
    {
        try {
            $query = Product::with([
                'category',
                'images' => function ($query) {
                    $query->select('image', 'product_id')->orderBy('product_id')->distinct();
                },
            ])->where('status',1);

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->has('brand_id')) {
                $query->where('brand_id', $request->brand_id);
            }

            if ($request->has('min_price')) {
                $query->where('default_price', '>=', $request->min_price);
            }

            if ($request->has('max_price')) {
                $query->where('default_price', '<=', $request->max_price);
            }

            $products = $query->get();

            return response()->json($products);
        } catch (\Exception $e) {
            dd($e);
        }

    }
}
