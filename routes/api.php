<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\testdbController;
use App\Http\Controllers\Api\Category_ProductController;
use App\Http\Controllers\Api\Info_SupplierController;
use App\Http\Controllers\Api\StaffController;
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

    // // test api
    Route::get('/testdb', [testdbController::class, 'index']);
    Route::get('/testdb/{id}', [testdbController::class, 'show']);
    Route::post('/testdb', [testdbController::class, 'store']);
    Route::put('/testdb/{id}', [testdbController::class, 'update']);
    Route::delete('/testdb/{id}', [testdbController::class, 'destroy']);
    // Route::resource('testdb', [testdbController::class]);


    //customer
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer/{id}', [CustomerController::class, 'show']);
    Route::post('/customer', [CustomerController::class, 'store']);
    Route::put('/customer/{id}', [CustomerController::class, 'update']);
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);


    //category_product
    Route::get('/category_product', [Category_ProductController::class, 'index']);
    Route::get('/category_product/{id}', [Category_ProductController::class, 'show']);
    Route::post('/category_product', [Category_ProductController::class, 'store']);
    Route::put('/category_product/{id}', [Category_ProductController::class, 'update']);
    Route::delete('/category_product/{id}', [Category_ProductController::class, 'destroy']);

    //Info_Supplier
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
