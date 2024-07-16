<?php

use App\Http\Controllers\MKController;
use App\Http\Controllers\MyAuthController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\PertemuanPhotoController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserKelasController;
use App\Models\Pertemuan;
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

Route::controller(UserKelasController::class)->group(function () {
    Route::get('user_kelas', 'get');
    Route::post('user_kelas', 'insert');
    Route::delete('user_kelas', 'delete');
    Route::put('user_kelas', 'update');
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

Route::controller(PertemuanController::class)->group(function () {
    Route::get('pertemuan', 'get_pertemuan');
    Route::post('pertemuan', 'insert');
    Route::put('pertemuan', 'update');
    Route::delete('pertemuan', 'delete');
    Route::get('pertemuan/{id}', 'get_pertemuan_by_id');
});


Route::controller(KehadiranController::class)->group(function () {
    Route::get('kehadiran', 'get_kehadiran');
    Route::post('kehadiran', 'insert');
    Route::put('kehadiran', 'update');
    Route::delete('kehadiran', 'delete');
});

Route::controller(PhotoController::class)->group(function () {
    Route::get('photo', 'get_photo');
    Route::post('photo', 'insert');
    Route::put('photo', 'update');
    Route::delete('photo', 'delete');
    Route::get('photo/{id}', 'get_photo_by_id');
});

Route::controller(PertemuanPhotoController::class)->group(function () {
    Route::get('pertemuan_photo', 'get_pertemuan_photo');
    Route::post('pertemuan_photo', 'AddPhoto');
    Route::put('pertemuan_photo', 'update');
    Route::delete('pertemuan_photo', 'delete');
    Route::get('pertemuan_photo/{id}', 'get_pertemuan_photo_by_id');
});


Route::get('smile', function() {
    return 'test API with authentication  ';
})->middleware('auth:sanctum');

Route::fallback(function(){
    return response()->json([
        'message' => 'API Route Not Found. Please contact your administrator.'], 404);
});

