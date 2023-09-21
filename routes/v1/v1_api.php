<?php

use App\Http\Controllers\V1\Admin\Employee\EmployeeController;
use App\Http\Controllers\V1\Admin\Employee\PayrollController;
use App\Http\Controllers\V1\Admin\SettingController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\Customer\CustomerController;
use App\Http\Controllers\V1\Customer\CustomerTransactionController;
use Illuminate\Support\Facades\Route;

// Echo
Route::get('/', function () {
    return response(['success' => true, 'version' => '1.0']);
});

// public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware(['abilities:customer'])->group(function () {
        Route::apiResource('transactions', CustomerTransactionController::class);
    });

    // Adminstartor
    Route::middleware(['abilities:admin'])->prefix('admin')->group(function () {
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('employees', EmployeeController::class);
        Route::apiResource('payrolls', PayrollController::class);
        Route::apiResource('settings', SettingController::class);
    });


    Route::post('logout', [AuthController::class, 'logout']);
});
