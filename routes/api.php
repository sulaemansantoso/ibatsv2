<?php

use App\Http\Controllers\MKController;
use App\Http\Controllers\MyAuthController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KehadiranController;
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


Route::controller(MKController::class)->group(function () {
    Route::get('mk', 'get_mk');
    Route::post('mk', 'insert');
    Route::put('mk', 'update');
    Route::delete('mk', 'delete');
});

Route::controller(PeriodeController::class)->group(function () {
   Route::get('periode', 'get_periode');
   Route::post('periode', 'insert');
   Route::put('periode', 'update');
   Route::delete('periode', 'delete');
});

Route::controller(KelasController::class)->group(function () {
    Route::get('kelas', 'get_kelas');
    Route::post('kelas', 'insert');
    Route::put('kelas', 'update');
    Route::delete('kelas', 'delete');
});

Route::get('smile', function() {
    return 'test API with authentication  ';
})->middleware('auth:sanctum');

Route::fallback(function(){
    return response()->json([
        'message' => 'API Route Not Found. Please contact your administrator.'], 404);
});

