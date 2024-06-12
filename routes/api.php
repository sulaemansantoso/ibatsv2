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
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::get('smile', function() {
    return 'catch you smiling huh';
})->middleware('auth:sanctum');



