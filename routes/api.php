<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\testdbController;
use App\Http\Controllers\Api\Category_ProductController;
use App\Http\Controllers\Api\Info_SupplierController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\Order_HistoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\Product_SupplierController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransportController;
use App\Http\Controllers\Api\Type_PostsController;
use App\Http\Controllers\Api\Type_VideoController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\Test_db_projectController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Front_end_Controller;
use App\Http\Controllers\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Customer;
use PhpParser\Node\Stmt\Return_;

// use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
//     // return 'hello world';
//     // Route::get('/testdb', [testdbController::class, 'index']);
//     // return $request->get('/testdb', 'testdbController');

//     });

Route::group(['middleware'=>'auth:sanctum'],function(){
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);

    // test api 
    Route::get('/testdb', [testdbController::class, 'index']);
    Route::get('/testdb/{id}', [testdbController::class, 'show']);
    Route::post('/testdb', [testdbController::class, 'store']);
    Route::put('/testdb/{id}', [testdbController::class, 'update']);
    Route::delete('/testdb/{id}', [testdbController::class, 'destroy']);


    //test db 
    Route::get('test_db_project',[Test_db_projectController::class,'index']);
    Route::post('test_db_project',[Test_db_projectController::class,'store']);
    Route::put('test_db_project/{id}',[Test_db_projectController::class,'update']);
    Route::get('test_db_project/{id}',[Test_db_projectController::class,'show']);
    Route::delete('test_db_project/{id}',[Test_db_projectController::class,'destroy']);

    Route::post('test_db_project',[Test_db_projectController::class,'upload']);


    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    //customer / oke
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer/{id}', [CustomerController::class, 'show']);
    Route::post('/customer', [CustomerController::class, 'store']);
    Route::put('/customer/{id}', [CustomerController::class, 'update']);
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);


    //category_product / oke
    Route::get('/category_product', [Category_ProductController::class, 'index']);
    Route::get('/category_product/{id}', [Category_ProductController::class, 'show']);
    Route::post('/category_product', [Category_ProductController::class, 'store']);
    Route::put('/category_product/{id}', [Category_ProductController::class, 'update']);
    Route::delete('/category_product/{id}', [Category_ProductController::class, 'destroy']);

    //Info_Supplier / oke
    Route::get('/info_supplier', [Info_SupplierController::class, 'index']);
    Route::get('/info_supplier/{id}', [Info_SupplierController::class, 'show']);
    Route::post('/info_supplier', [Info_SupplierController::class, 'store']);
    Route::put('/info_supplier/{id}', [Info_SupplierController::class, 'update']);
    Route::delete('/info_supplier/{id}', [Info_SupplierController::class, 'destroy']);

    //staff
    Route::get('/staff', [StaffController::class, 'index']);
    Route::get('/staff/{id}', [StaffController::class, 'show']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::put('/staff/{id}', [StaffController::class, 'update']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy']);


    //order_history
    Route::get('/order_history', [Order_HistoryController::class, 'index']);
    Route::get('/order_history/{id}', [Order_HistoryController::class, 'show']);
    Route::post('/order_history', [Order_HistoryController::class, 'store']);
    Route::put('/order_history/{id}', [Order_HistoryController::class, 'update']);
    Route::delete('/order_history/{id}', [Order_HistoryController::class, 'destroy']);

    //Order
    Route::get('/order', [OrderController::class, 'index']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::put('/order/{id}', [OrderController::class, 'update']);
    Route::delete('/order/{id}', [OrderController::class, 'destroy']);


    //Posts
    Route::get('/posts', [PostsController::class, 'index']);
    Route::get('/posts/{id}', [PostsController::class, 'show']);
    Route::post('/posts', [PostsController::class, 'store']);
    Route::put('/posts/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);


    //Product_Supplier
    Route::get('/product_supplier', [Product_SupplierController::class, 'index']);
    Route::get('/product_supplier/{id}', [Product_SupplierController::class, 'show']);
    Route::post('/product_supplier', [Product_SupplierController::class, 'store']);
    Route::put('/product_supplier/{id}', [Product_SupplierController::class, 'update']);
    Route::delete('/product_supplier/{id}', [Product_SupplierController::class, 'destroy']);


    //product
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);


    //Transport
    Route::get('/transport', [TransportController::class, 'index']);
    Route::get('/transport/{id}', [TransportController::class, 'show']);
    Route::post('/transport', [TransportController::class, 'store']);
    Route::put('/transport/{id}', [TransportController::class, 'update']);
    Route::delete('/transport/{id}', [TransportController::class, 'destroy']);


    //Type_Posts 
    Route::get('/type_posts', [Type_PostsController::class, 'index']);
    Route::get('/type_posts/{id}', [Type_PostsController::class, 'show']);
    Route::post('/type_posts', [Type_PostsController::class, 'store']);
    Route::put('/type_posts/{id}', [Type_PostsController::class, 'update']);
    Route::delete('/type_posts/{id}', [Type_PostsController::class, 'destroy']);


    //Type_Video
    Route::get('/type_video', [Type_VideoController::class, 'index']);
    Route::get('/type_video/{id}', [Type_VideoController::class, 'show']);
    Route::post('/type_video', [Type_VideoController::class, 'store']);
    Route::put('/type_video/{id}', [Type_VideoController::class, 'update']);
    Route::delete('/type_video/{id}', [Type_VideoController::class, 'destroy']);


    //Video
    Route::get('/video', [VideoController::class, 'index']);
    Route::get('/video/{id}', [VideoController::class, 'show']);
    Route::post('/video', [VideoController::class, 'store']);
    Route::put('/video/{id}', [VideoController::class, 'update']);
    Route::delete('/video/{id}', [VideoController::class, 'destroy']);


    //Warehouse
    Route::get('/warehouse', [WarehouseController::class, 'index']);
    Route::get('/warehouse/{id}', [WarehouseController::class, 'show']);
    Route::post('/warehouse', [WarehouseController::class, 'store']);
    Route::put('/warehouse/{id}', [WarehouseController::class, 'update']);
    Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy']);


    
});
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/register',[AuthController::class,'register']);
    
    // Route::get('testdb', function);
    // Route::get('testdb', function ($id) {
        
    // });
Route::group(['namespace' => 'App\Http\Controllers\Api'], function() {
    Route::resource('users', 'UserController');
    // Route::resource('staff', 'StaffController');
    // Route::resource('testdb', 'testdbController');
});
    // Route::get('/testdb', [testdbController::class, 'index']);
    // Route::get('/testdb/{id}', [testdbController::class, 'show']);
    // Route::post('/testdb', [testdbController::class, 'store']);
    // Route::put('/testdb/{id}', [testdbController::class, 'update']);
    // Route::delete('/testdb/{id}', [testdbController::class, 'destroy']);




    
    // Front end
    Route::get('/get_product',[Front_end_Controller::class,'index']);
    // hiển thị sản phẩm theo danh mục
    Route::get('/get_product_by_category',[Front_end_Controller::class,'show_product_by_category']);

    Route::get('/get_product/{id}', [Front_end_Controller::class, 'show']);

    //front end video 
    Route::get('/get_video',[Front_end_Controller::class,'video']);
    // Route::get('/get_posts',[Front_end_Controller::class,'video']);
    Route::get('/get_posts',[Front_end_Controller::class,'posts']);
    Route::get('/get_posts/{id}', [Front_end_Controller::class, 'show_posts']);


    // Route::get('/testleftjion', [Front_end_Controller::class, 'testleftjion']);

    // upload 

   Route::post('upload',[UploadController::class,'upload']);




