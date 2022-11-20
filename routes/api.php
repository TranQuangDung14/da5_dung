<?php

use App\Http\Controllers\Api\testdbController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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


    Route::get('/testdb', [testdbController::class, 'index']);
    // Route::get('/testdb/{id}', [testdbController::class, 'show']);
    // Route::post('/testdb', [testdbController::class, 'store']);
    // Route::put('/testdb/{id}', [testdbController::class, 'update']);
    // Route::delete('/testdb/{id}', [testdbController::class, 'destroy']);
    // Route::resource('testdb', [testdbController::class]);
});
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/register',[AuthController::class,'register']);
    
    // Route::get('testdb', function);
    // Route::get('testdb', function ($id) {
        
    // });
Route::group(['namespace' => 'App\Http\Controllers\Api'], function() {
    Route::resource('users', 'UserController');
    Route::resource('staff', 'StaffController');
    // Route::resource('testdb', 'testdbController');
});
