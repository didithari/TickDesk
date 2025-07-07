<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunAdminController;

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
Route::Post('/admin/akun/tambah-data', [AkunAdminController::class, 'save']);




