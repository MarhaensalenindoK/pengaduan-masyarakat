<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('authentication.login');
// });

Route::get('/', [LoginController::class, 'check']);
// No Auth

Route::get('/home', [Controllers\LandingPageController::class, 'index'])->name('landingpage');

Route::get('/{clinicId}/detail-clinic', [Controllers\LandingPageController::class, 'detailClinic'])->name('detail_clinic');

// Auth
Route::get('/login', [LoginController::class, 'check'])->name('login');
Route::get('/register', [LoginController::class, 'registerView'])->name('register');

Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('auth');
Route::post('/registration', [LoginController::class, 'registration'])->name('registration');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('reset-password', [LoginController::class, 'resetPassword'])->name('resetPassword');
Route::prefix('masyarakat')->group(function () {
    Route::get('/dashboard', [Controllers\Masyarakat\DashboardController::class, 'index']);
    Route::get('/pengaduan', [Controllers\Masyarakat\DashboardController::class, 'getPengaduan']);
    Route::post('/pengaduan', [Controllers\Masyarakat\DashboardController::class, 'createPengaduan']);
});

Route::group(['middleware' => ['auth', 'role:ADMIN'], 'prefix' => 'admin'], function(){
    Route::get('/dashboard', [Controllers\Admin\DashboardController::class, 'index']);
    Route::get('/account-management', [Controllers\Admin\AccountManagementController::class, 'index']);
    Route::get('/masyarakat-management', [Controllers\Admin\MasyarakatManagementController::class, 'index']);

    Route::prefix('database')->group(function () {
        Route::get('/users', [Controllers\Admin\AccountManagementController::class, 'getUser']);
        Route::post('/user', [Controllers\Admin\AccountManagementController::class, 'createAccount']);
        Route::patch('/user', [Controllers\Admin\AccountManagementController::class, 'updateAccount']);
        Route::delete('/user', [Controllers\Admin\AccountManagementController::class, 'deleteAccount']);
        Route::post('/user/reset-password', [Controllers\Admin\AccountManagementController::class, 'resetPassword']);

        Route::get('/masyarakat', [Controllers\Admin\MasyarakatManagementController::class, 'getMasyarakat']);
        Route::post('/masyarakat', [Controllers\Admin\MasyarakatManagementController::class, 'createMasyarakat']);
        Route::patch('/masyarakat', [Controllers\Admin\MasyarakatManagementController::class, 'updateMasyarakat']);
        Route::delete('/masyarakat', [Controllers\Admin\MasyarakatManagementController::class, 'deleteMasyarakat']);
        Route::post('/masyarakat/reset-password', [Controllers\Admin\MasyarakatManagementController::class, 'resetPassword']);

        Route::get('/pengaduan', [Controllers\Admin\DashboardController::class, 'getPengaduan']);
    });

    Route::patch('/pengaduan', [Controllers\Admin\DashboardController::class, 'updatePengaduan']);
});

Route::group(['middleware' => ['auth', 'role:PETUGAS'], 'prefix' => 'petugas'], function(){
    Route::get('/dashboard', [Controllers\Petugas\DashboardController::class, 'index']);
    Route::get('/account-masyarakat', [Controllers\Petugas\MasyarakatManagementController::class, 'index']);

    Route::prefix('database')->group(function () {
        Route::get('/masyarakat', [Controllers\Petugas\MasyarakatManagementController::class, 'getMasyarakat']);
        Route::post('/masyarakat', [Controllers\Petugas\MasyarakatManagementController::class, 'createMasyarakat']);
        Route::patch('/masyarakat', [Controllers\Petugas\MasyarakatManagementController::class, 'updateMasyarakat']);
        Route::delete('/masyarakat', [Controllers\Petugas\MasyarakatManagementController::class, 'deleteMasyarakat']);
        Route::post('/masyarakat/reset-password', [Controllers\Petugas\MasyarakatManagementController::class, 'resetPassword']);

        Route::get('/pengaduan', [Controllers\Admin\DashboardController::class, 'getPengaduan']);
    });

    Route::patch('/pengaduan', [Controllers\Admin\DashboardController::class, 'updatePengaduan']);
});
