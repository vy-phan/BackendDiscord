<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);

Route::post('/login', [AuthController::class, 'login'])->name('login');

// Bỏ middleware auth:sanctum vì đã được áp dụng trong nhóm api
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');