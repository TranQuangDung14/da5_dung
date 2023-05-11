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
use Exception;
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
        try {
            $product = Product::with([
                'category',
                'images' => function ($query) {
                    $query->select('image', 'product_id')->orderBy('product_id')->distinct();
                },
            ])
                ->select(['id', 'name','quantity','default_price', 'category_id'])
                ->orderBy('id', 'desc')
                ->get();
                // dd($product);
            return response()->json([
                'category_product' => Category_product::where('status', 1)->select('id', 'name as name_cate')->get(),
                'product'=>$product,
            ]);
            // return Product::all();
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'messege' => 'Thất bại!',
            ], 200);
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
        $input = $request->all();
        $rules = array(
            'name' => 'required',
            'default_price' => 'required',
            // 'price' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'default_price.required' => 'Giá tiền mặc định không được phép trống!',
            // 'price.required' => 'Giá tiền không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        // $baseUrl = env('APP_URL') . '/';
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
            $product->tech_specs =  (!empty($request->tech_specs)) ? $request->tech_specs : null;
            // $product->price =  (!empty($request->price)) ? $request->price : null;
            $product->description =  (!empty($request->description)) ? $request->description : null;
            $product->quantity=0;
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
            // $warehouse = new Warehouse();
            // $warehouse->product_id = $product->id;
            // // $warehouse->amount = $request->amount;
            // $warehouse->save();

            // $image = new
            DB::commit();
            return response()->json([
                'messege' => $product,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'messege' => 'Thất bại!',
            ], 200);
        }
    }
    //

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::with(['warehouse', 'images', 'category'])->findOrFail($id);
            $images = $product->images;
            return response()->json([
                'product' => $product,
                'images' => $images
            ]);
        } catch (\Exception $e) {

            return response()->json([
                dd($e),

            ], 200);
        }
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
        // dd($request->all());
        //
        // dd(request('name','dd'));
        // return response()->json([
        //     'message' => 'Cập nhật sản phẩm thành công!',
        //     'product' =>request('name','dd'),
        //     'input' => $request->all()
        // ], 200);
        $input = $request->all();
        $rules = array(
            'name' => 'required',
            'default_price' => 'required',
            // 'price' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'default_price.required' => 'Giá tiền mặc định không được phép trống!',
            // 'price.required' => 'Giá tiền không được phép trống!',
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
            // $product->price = $request->price;
            $product->tech_specs =  (!empty($request->tech_specs)) ? $request->tech_specs : null;
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

            // Cập nhật ảnh sản phẩm
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
            // $warehouse = Warehouse::where('product_id', $id)->firstOrFail();
            // $warehouse->delete();

            DB::commit();
            return response()->json([
                'message' => 'Xóa sản phẩm thành công!',
            ], 200);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            return response()->json([
                'message' => 'Xóa sản phẩm thất bại!',
            ], 400);
        }
    }
}
