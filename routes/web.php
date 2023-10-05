<?php

use App\Http\Controllers\PayPalController;
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
    return view('welcome');
});

Route::get('payment/success', [PayPalController::class, 'successPayment'])->name('paypal.payment.success');
Route::get('payment/cancel', [PayPalController::class, 'cancelledPayment'])->name('paypal.payment.cancel');
Route::get('payment/message', [PayPalController::class, 'messagePayment'])->name('paypal.payment.message');
Route::get('payment/{temp_token}', [PayPalController::class, 'handlePayment'])->name('paypal.payment');
