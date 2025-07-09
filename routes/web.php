<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunAdminController;
use App\Http\Controllers\AkunSupportController;
use App\Http\Controllers\AkunSupervisorController;
use App\Http\Controllers\SupportTicketController;


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

//Dashboard admin : Akun Developer
Route::get('/admin/akun', [AkunAdminController::class, 'index'])->name('akunadmin');
Route::Post('/admin/akun/tambah-data', [AkunAdminController::class, 'save']);
Route::delete('/dashboard/admin/akun/user/hapus-akun/{username}', [AkunAdminController::class, 'hapusData']);
Route::get('/akun/edit/{username}', [AkunAdminController::class, 'edit'])->name('akun.edit');
Route::post('/akun/update-data/{username}', [AkunAdminController::class, 'update'])->name('akun.update');

//Dashboard admin : Akun Support
Route::get('/admin/support', [AkunSupportController::class, 'index'])->name('akun.support');
Route::Post('/admin/support/tambah-data', [AkunSupportController::class, 'save']);
Route::get('/admin/support/edit-data/{username}', [AkunSupportController::class, 'edit']);
Route::Post('/admin/support/update-data/{username}', [AkunSupportController::class, 'update']);


//Dashboard admin : Ticket Support
Route::get('/admin/ticketsupport', [SupportTicketController::class, 'index'])->name('supportticket');
// Route::Post('/admin/akun/tambah-data', [SupportTicketController::class, 'save']);
// Route::delete('/dashboard/admin/akun/user/hapus-akun/{username}', [SupportTicketController::class, 'hapusData']);
// Route::get('/akun/edit/{username}', [SupportTicketController::class, 'edit'])->name('akun.edit');
// Route::post('/akun/update-data/{username}', [SupportTicketController::class, 'update'])->name('akun.update');

//Dashboard admin : Akun Supervisor
Route::get('/admin/Supervisor', [AkunSupervisorController::class, 'index'])->name('akun.supervisor');
Route::Post('/admin/supervisor/tambah-data', [AkunSupervisorController::class, 'save']);
Route::delete('/admin/supervisor/user/hapus-akun/{username}', [AkunSupervisorController::class, 'hapusData']);
Route::get('/admin/supervisor/edit-data/{username}', [AkunSupervisorController::class, 'edit']);
Route::Post('/admin/supervisor/update-data/{username}', [AkunSupervisorController::class, 'update']);


