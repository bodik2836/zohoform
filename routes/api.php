<?php

use App\Http\Controllers\Zoho\FormController as ZohoFormController;
use App\Http\Controllers\Zoho\Settings\DealStagesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/zoho/form', [ZohoFormController::class, 'store'])->name('zoho.form.store');
Route::get('/zoho/settings/deal-stages', [DealStagesController::class, 'index']);
