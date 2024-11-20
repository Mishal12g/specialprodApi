<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ExecutorController;
use App\Http\Controllers\Api\V1\AuthCustomerController;
use App\Http\Controllers\Api\V1\AuthExecutorController;
use App\Http\Controllers\Api\V1\CategoryExecutorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/customer/register', [AuthCustomerController::class, 'register']);
Route::post('/customer/login', [AuthCustomerController::class, 'login']);
Route::post('/customer/logout', [AuthCustomerController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/customer', [CustomerController::class, 'show'])
    ->middleware('auth:sanctum');

Route::post('/executor/register', [AuthExecutorController::class, 'register']);
Route::post('/executor/login', [AuthExecutorController::class, 'login']);
Route::post('/executor/logout', [AuthExecutorController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/executor/address', [ExecutorController::class, 'updateAddress'])->middleware('auth:sanctum');
Route::get('/executor', [ExecutorController::class, 'show'])
    ->middleware('auth:sanctum');


Route::get('/executors/search', [ExecutorController::class, 'searchByCityAndCategory']);

Route::apiResources([
'/categories'=>CategoryController::class,
'/orders'=>OrderController::class,
'/category_executor'=>CategoryExecutorController::class,
]);