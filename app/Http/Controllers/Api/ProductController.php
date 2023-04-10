<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Category_product;
use App\Models\Info_Supplier;
use App\Models\Product_Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UploadController;
use App\Models\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 'supplier'=>Info_Supplier::where('status',1)->select('id','name')->get(),
        $baseUrl = env('APP_URL') . '/';
        return response()->json([
            'category_product' => Category_product::where('status', 1)->select('id', 'name as name_cate')->get(),
            //use to test post
            'product' =>  DB::table('da5_product')
                ->leftJoin('da5_warehouse', 'da5_product.id', '=', 'da5_warehouse.product_id')
                ->leftJoin('da5_category_product', 'da5_category_product.id', '=', 'da5_product.category_id')
                ->select([
                    'da5_product.*',
                    'da5_warehouse.amount',
                    'da5_category_product.name as name_cate',
                    DB::raw("CONCAT('$baseUrl','storage/', da5_product.image) as img_src")
                ])
                ->where('da5_product.status', 1)
                ->orderBy('id', 'desc')
                ->get(),

            'product_all' => Product::all(),
        ], 200);
        // return Product::all();
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
            'name' => 'required',
            'default_price' => 'required',
            'price' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'default_price.required' => 'Giá tiền mặc định không được phép trống!',
            'price.required' => 'Giá tiền không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        DB::beginTransaction();
        try {
            // return $result;
            $product = new Product();
            $product->category_id =  (!empty($request->category_id)) ? $request->category_id : null;
            $product->name = $request->name;
            $product->default_price = $request->default_price;
            $product->price = $request->price;
            $product->description =  (!empty($request->description)) ? $request->description : null;
            $product->save();


            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $image) {
                    // Kiểm tra file có phải là ảnh và dung lượng không quá giới hạn cho phép
                    if ($image->isValid() && in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']) && $image->getSize() <= 5048000) {
                        // chuỗi đặt tên file ảnh
                        $filename = time() . '-' . Str::slug($image->getClientOriginalName(), '-') . '.' . $image->getClientOriginalExtension();
                        // Lưu ảnh vào thư mục image/product
                        $image->storeAs('image/product', $filename);

                        // Thêm bản ghi vào bảng images
                        Image::create([
                            'product_id' => $product->id,
                            'image' => $filename,
                        ]);
                    }
                }
            }
            $warehouse = new Warehouse();
            $warehouse->product_id = $product->id;
            // $warehouse->amount = $request->amount;
            $warehouse->save();

            // $image = new
            DB::commit();
            return response()->json([
                'messege' => $product,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return response()->json([
                'messege' => 'Thất bại!',
            ], 200);
        }
    }
    //
    // public function upload(Request $request){
    //     $image =$request->file('image');
    //     if($request->hasFile('image')){
    //         $new_name =rand().'.'.$image->getClientOriginalExtension();
    //         $image->move(public_path('/uploads/images'),$new_name);
    //         return response()->json($new_name);
    //     }else{
    //         return response()->json('ảnh trống');
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $warehouse = Warehouse::where('product_id', $id)->first();
        $images = Image::where('product_id', $id)->get();
        return response()->json([
            'product' => $product,
            'warehouse' => $warehouse,
            'images' => $images
        ]);
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
            'name' => 'required',
            'default_price' => 'required',
            'price' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'default_price.required' => 'Giá tiền mặc định không được phép trống!',
            'price.required' => 'Giá tiền không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->category_id =  (!empty($request->category_id)) ? $request->category_id : null;
            $product->name = $request->name;
            $product->default_price = $request->default_price;
            $product->price = $request->price;

            $product->description =  (!empty($request->description)) ? $request->description : null;
            // Nhận ID của hình ảnh được chọn để lưu giữ
            $imageIds = $request->input('image_ids', []);

            // Xóa hình ảnh không được chọn để lưu giữ
            $imagesToDelete = $product->images()->whereNotIn('id', $imageIds)->get();
            foreach ($imagesToDelete as $image) {
                Storage::delete('image/product/' . $image->image);
                $image->delete();
            }
            // Update product data
            $product->save();

            // Update product images
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $image) {
                    if ($image->isValid() && in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']) && $image->getSize() <= 5048000) {
                        $filename = time() . '-' . Str::slug($image->getClientOriginalName(), '-') . '.' . $image->getClientOriginalExtension();
                        $image->storeAs('image/product', $filename);
                        Image::create([
                            'product_id' => $product->id,
                            'image' => $filename,
                        ]);
                    }
                }
            }
            // Update product warehouse
            // $warehouse = Warehouse::where('product_id', $id)->firstOrFail();
            // $warehouse->amount = $request->amount;
            // $warehouse->save();

            DB::commit();
            return response()->json([
                'message' => 'Cập nhật sản phẩm thành công!',
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                dd($e),
                'message' => 'Cập nhật sản phẩm thất bại!',
            ], 200);
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
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            // Xóa các ảnh sản phẩm
            foreach ($product->images as $image) {
                Storage::delete('image/product/' . $image->image);
                $image->delete();
            }

            // Xóa sản phẩm
            $product->delete();

            // Xóa kho sản phẩm
            $warehouse = Warehouse::where('product_id', $id)->firstOrFail();
            $warehouse->delete();

            DB::commit();
            return response()->json([
                'message' => 'Xóa sản phẩm thành công!',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Xóa sản phẩm thất bại!',
            ], 400);
        }
    }
}
