<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard');
});

/**
 * Google OAuth
 */
use App\Http\Controllers\Auth\GoogleController;

Route::get('login/google', [GoogleController::class, 'login'])->name('auth.google.login');
Route::get('login/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

/**
 * VPN Settings
 */
use App\Http\Livewire\Vpn;

Route::get('/vpn', Vpn::class);