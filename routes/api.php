<?php

use App\Http\Controllers\MyAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [MyAuthController::class, 'login']);

Route::controller(MyAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('register-2', 'register2');
    Route::post('login-2', 'login2');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::get('getjson', 'getjson');
});

Route::get('smile', function() {
    return 'test API with authentication  ';
})->middleware('auth:sanctum');

Route::fallback(function(){
    return response()->json([
        'message' => 'API Route Not Found. Please contact your administrator.'], 404);
});

