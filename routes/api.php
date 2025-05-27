<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// LƯU Ý : CÁI NÀY NÈ MAI MỐT CÓ XỬ LÍ BẢO MẬT BỎ MẤY ROUTER VÔ ĐÂY NÈ   

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);

Route::get('/notification', [NotificationController::class, 'index']);
Route::get('/notification/{id}', [NotificationController::class, 'show']);
Route::get('/notification/user/{userId}', [NotificationController::class, 'getByUserId']);
Route::post('/notification', [NotificationController::class, 'store']);
Route::put('/notification/{id}', [NotificationController::class, 'update']);
Route::delete('/notification/{id}', [NotificationController::class, 'destroy']);
Route::put('/notification/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
