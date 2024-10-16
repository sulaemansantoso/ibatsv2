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
 URL::forceScheme('https');



Route::post('login', [MyAuthController::class, 'login']);


Route::controller(MyAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('register-2', 'register2');
    Route::post('login-2', 'login2');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::get('getjson', 'getjson');
    Route::post('import_user_by_excel', 'import_user_by_excel');
});

Route::controller(UserKelasController::class)->group(function () {
    Route::get('user_kelas', 'get');
    Route::post('user_kelas', 'insert');
    Route::delete('user_kelas', 'delete');
    Route::put('user_kelas', 'update');
    Route::post('dosen_kelas_import', 'import_from_excel');
    Route::post('dosen_kelas_import_simba', 'import_from_simba');
    Route::post('mahasiswa_kelas_import', 'import_mahasiswa_from_excel');
    Route::post('kelas_by_kode_user', 'get_kelas_by_id');
    Route::post('kelas_by_kode_user_custom', 'get_kelas_by_id_custom');
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
    Route::post('pertemuan_by_id_kelas', 'get_pertemuan_by_id_kelas');
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
    Route::post('pertemuan_photo_by_id', 'get_pertemuan_photo_by_id');
    Route::post('pertemuan_photo', 'AddPhoto');
    Route::post('pertemuan_photo_add','AddPhoto2');
    Route::post('pertemuan_photo_test', 'TestPhoto');
    Route::post('pertemuan_photo_tag_photo', 'tag_pertemuan_photo');
    Route::put('pertemuan_photo', 'update');
    Route::delete('pertemuan_photo', 'delete');
    Route::post('pertemuan_photo_untag_photo', 'untag_pertemuan_photo');
   // Route::get('pertemuan_photo/{id}', 'get_pertemuan_photo_by_id');
});


Route::get('smile', function() {
    return 'test API with authentication  ';
})->middleware('auth:sanctum');

Route::fallback(function(){
    return response()->json([
        'message' => 'API Route Not Found. Please contact your administrator.'], 404);
});

