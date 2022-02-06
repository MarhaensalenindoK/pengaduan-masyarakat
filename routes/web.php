<?php

use Illuminate\Support\Facades\Route;
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

// Auth
Route::get('/', [LoginController::class, 'check']);
Route::get('/login', function () {
    return view('authentication.login');
})->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::group(['middleware' => ['auth']], function(){
//     Route::get('/home', function () {
//         return view('layout');
//     })->name('home');
// });
Route::group(['middleware' => ['auth', 'role:ADMIN']], function(){
    Route::get('/dashboard', function () {
        return view('layout');
    })->name('home');
});