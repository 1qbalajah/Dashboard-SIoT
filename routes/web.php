<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ServoController;
use App\Http\Controllers\LCDController;

Route::middleware('guest')->group(function () {

    Route::get('/', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister']);

    Route::post('/register', [AuthController::class, 'register']);
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/realtime', [DashboardController::class, 'realtimeData']);
    Route::post('/servo/send', [ServoController::class, 'send']);
    Route::post('/lcd/send', [LCDController::class, 'send']);

    Route::middleware('role:admin')->group(function () {

        Route::resource('sensor', SensorController::class);
    });

    Route::middleware('role:user')->group(function () {

        Route::resource('device', DeviceController::class);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
