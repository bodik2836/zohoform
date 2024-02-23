<?php

use App\Http\Controllers\Zoho\AuthController as ZohoAuthController;
use App\Http\Controllers\Zoho\FormController as ZohoFormController;
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
Route::get('/zoho/auth', [ZohoAuthController::class, 'auth'])->name('zoho.auth');
Route::get('/oauthredirect', [ZohoAuthController::class, 'oauthredirect'])->name('zoho.oauthredirect');

Route::get('/', [ZohoFormController::class, 'index'])->name('home');
