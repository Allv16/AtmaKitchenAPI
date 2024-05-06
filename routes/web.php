<?php

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
    return view('emailVerification');
});

Route::get('/verification', function () {
    return view('verification');
});

Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\VerificationController::class, 'verify']);
