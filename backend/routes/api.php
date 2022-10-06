<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//header('Access-Control-Allow-Origin:  *');
//header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
//header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test', [\App\Http\Controllers\TestController::class, 'receive_msg']);
Route::get('/test1', [\App\Http\Controllers\CustomerController::class, 'index']);
Route::post('/customer', [\App\Http\Controllers\CustomerController::class, 'insert']);
Route::post('/customer/update', [\App\Http\Controllers\CustomerController::class, 'update']);
Route::post('/customer/update/confirm', [\App\Http\Controllers\CustomerController::class, 'update_confirm']);
Route::post('/customer/delete', [\App\Http\Controllers\CustomerController::class, 'delete']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);
Route::post('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard']);
Route::post('/admin/create-blog-post', [\App\Http\Controllers\AdminBlogController::class, 'index']);
Route::post('/admin/view-blog-post', [\App\Http\Controllers\AdminBlogController::class, 'view_post']);
Route::post('/admin/delete-blog-post', [\App\Http\Controllers\AdminBlogController::class, 'delete_post']);
Route::post('/blog/update', [\App\Http\Controllers\AdminBlogController::class, 'update']);
Route::post('/blog/update/confirm', [\App\Http\Controllers\AdminBlogController::class, 'blog_update_confirm']);
Route::post('/admin/home/view-blog-post', [\App\Http\Controllers\AdminBlogController::class, 'home_view_post']);
Route::post('/customer/create-room/', [\App\Http\Controllers\ChatRoomController::class, 'create_room']);
Route::post('/customer/live-chat', [\App\Http\Controllers\ChatRoomController::class, 'live_chat']);
Route::post('/customer/previous-msg/{id}', [\App\Http\Controllers\ChatRoomController::class, 'previous_msg']);
Route::post('/admin/view-chat-post', [\App\Http\Controllers\AdminChatRoomController::class, 'index']);
Route::post('/admin/live-chat', [\App\Http\Controllers\AdminChatRoomController::class, 'live_chat']);
Route::post('/admin/previous-msg/{id}', [\App\Http\Controllers\AdminChatRoomController::class, 'previous_msg']);
Route::post('/admin/receive-chat', [\App\Http\Controllers\AdminChatRoomController::class, 'receive_msg']);
Route::post('/customer/receive-chat', [\App\Http\Controllers\ChatRoomController::class, 'receive_msg']);
