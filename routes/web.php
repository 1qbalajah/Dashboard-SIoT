<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TitleContoller;
use App\Http\Controllers\RouteContoller;
use App\Http\Controllers\QueryContoller;
use App\Http\Controllers\PostContoller;
use App\Http\Controllers\SensorController;

Route::get('/sensor', [SensorController::class, 'index']);
Route::post('/sensor', [SensorController::class, 'store']);


Route::get('/', [SensorController::class, 'index']);







