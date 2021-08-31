<?php

use App\Http\Controllers\Api\GeneralApiController;
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

Route::post('upload-file', [GeneralApiController::class, 'uploadFile'])->name('api.uploadFile');
Route::get('last-file', [GeneralApiController::class, 'lastFile'])->name('api.lastFile');
Route::post('change-file', [GeneralApiController::class, 'changeFile'])->name('api.changeFile');
Route::post('use-file', [GeneralApiController::class, 'useFile'])->name('api.useFile');
Route::post('encrypt', [GeneralApiController::class, 'encryptFile'])->name('api.encryptFile');
Route::post('decrypt', [GeneralApiController::class, 'decryptFile'])->name('api.encryptFile');
