<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunAdminController;
use App\Http\Controllers\AkunSupportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin/akun', [AkunAdminController::class, 'index'])->name('akunadmin');
Route::get('admin/support', [AkunSupportController::class, 'index'])->name('akun.support');
Route::Post('/admin/akun/tambah-data', [AkunAdminController::class, 'save']);
Route::delete('/dashboard/admin/akun/user/hapus-akun/{username}', [AkunAdminController::class, 'hapusData']);
Route::get('/akun/edit/{username}', [AkunAdminController::class, 'edit'])->name('akun.edit');
Route::post('/akun/update/{username}', [AkunAdminController::class, 'update'])->name('akun.update');





