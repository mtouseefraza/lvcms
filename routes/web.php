<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\UserPermissionController;


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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('sections', SectionController::class)->except(['show']);
    Route::get('sections/export', [SectionController::class, 'export'])->name('sections.export');  

    Route::resource('models', ModelsController::class)->except(['show']);
    Route::get('models/export', [ModelsController::class, 'export'])->name('models.export');

    Route::resource('user-permission', UserPermissionController::class)->except(['show']);
    Route::get('user-permission/export', [UserPermissionController::class, 'export'])->name('user-permission.export');


    Route::middleware('role:superadmin')->group(function () {
        Route::get('/superadmin', function () {
            return 'Superadmin Area';
        });
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return 'Admin Area';
        });
    });

    Route::middleware('role:user')->group(function () {
        Route::get('/user', function () {
            return 'User Area';
        });
    });
});