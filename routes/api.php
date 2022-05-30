<?php

use App\Http\Controllers\API\DataPegawaiController;
use App\Http\Controllers\API\JabatanController;
use App\Http\Controllers\API\UserController;
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
Route::post('login', [UserController::class, 'login']);
Route::post('loginpegawai', [UserController::class, 'loginpegawai']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum,web,pegawai'])->group(function () {
    //CRUD USER OLEH ADMIN DAN MANAGER
    Route::post('addAkunPegawai', [UserController::class, 'addAkunPegawai'])->middleware('role:Manager,Admin');
    Route::get('allUser', [UserController::class, 'allUser'])->middleware('role:Manager,Admin');
    Route::get('editUser/{id}', [UserController::class, 'editUser'])->middleware('role:Manager,Admin');
    Route::post('updateUser', [UserController::class, 'updateUser'])->middleware('role:Manager,Admin');
    Route::delete('hapusUser/{id}', [UserController::class, 'hapusUser'])->middleware('role:Manager,Admin');

    //CRUD JABATAN OLEH ADMIN DAN MANAGER
    Route::get('alljabatan',[JabatanController::class, 'alljabatan'])->middleware('role:Manager,Admin');
    Route::post('tambahjabatan', [JabatanController::class, 'tambahjabatan'])->middleware('role:Manager,Admin');
    Route::get('editjabatan/{id}',[JabatanController::class, 'editjabatan'])->middleware('role:Manager,Admin');
    Route::post('updatejabatan',[JabatanController::class, 'updatejabatan'])->middleware('role:Manager,Admin');
    Route::delete('hapusjabatan/{id}', [JabatanController::class, 'hapusjabatan'])->middleware('role:Manager,Admin');

    //PEGAWAI
    Route::post('isibiodata', [DataPegawaiController::class, 'isibiodata'])->middleware('role:Pegawai');
    Route::get('datapegawai', [DataPegawaiController::class, 'datapegawai'])->middleware('role:Manager,Admin');
    Route::get('detailpegawai/{id}', [DataPegawaiController::class, 'detailpegawai'])->middleware('role:Manager,Admin');
    Route::get('editpegawai/{id}', [DataPegawaiController::class, 'editpegawai'])->middleware('role:Admin, Pegawai');
    Route::post('updatepegawai', [DataPegawaiController::class, 'updatepegawai'])->middleware('role:Admin,Pegawai');
    Route::delete('hapuspegawai/{id}' , [DataPegawaiController::class, 'hapuspegawai'])->middleware('role:Admin, Pegawai');
});
