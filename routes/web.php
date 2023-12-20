<?php

use App\Http\Controllers\AfterLoginController;
use App\Http\Controllers\Master\TimbanganController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Master\BarangController;
use App\Http\Controllers\Web\Master\TimbanganController as MasterTimbanganController;
use App\Http\Controllers\Web\Master\UsersController;
use App\Http\Controllers\Web\TimbanganController as WebTimbanganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/after-login', [AfterLoginController::class, 'index'])->name('after-login');

// Timbangan
Route::resource('timbangan', TimbanganController::class);

// Website
Route::get('w-dashboard', [DashboardController::class, 'index'])->name('w-dashboard.index');
Route::resource('w-timbangan', WebTimbanganController::class);
Route::resource('w-cek-manual', MasterTimbanganController::class);
Route::resource('m-barang', BarangController::class);
Route::resource('m-users', UsersController::class);



