<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\AuthUserController;
use App\Http\Controllers\Api\V1\AuthExecutorController;
use App\Http\Controllers\Api\V1\TransportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [AuthUserController::class, 'register']);
Route::post('/user/login', [AuthUserController::class, 'login']);
Route::post('/user/logout', [AuthUserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'show'])
    ->middleware('auth:sanctum');
    Route::put('/user', [UserController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    
Route::get('/customer/orders/{id}', [OrderController::class, 'showCustomerOrders'])
        ->middleware('auth:sanctum');
Route::get('/executor/orders/{id}', [OrderController::class, 'showExecutorOrders'])
        ->middleware('auth:sanctum');
    
// Route::post('/executor/register', [AuthExecutorController::class, 'register']);
// Route::post('/executor/login', [AuthExecutorController::class, 'login']);
// Route::post('/executor/logout', [AuthExecutorController::class, 'logout'])->middleware('auth:sanctum');
// Route::get('/executor', [ExecutorController::class, 'show'])
// ->middleware('auth:sanctum');

Route::put('/transport/address', [TransportController::class, 'updateAddress'])->middleware('auth:sanctum');
Route::post('/transport/search', [TransportController::class, 'searchTransport']);

Route::get('/executors/search', [ExecutorController::class, 'searchByCityAndCategory']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        '/orders' => OrderController::class,
        '/transports' => TransportController::class,
    ]);
});

Route::apiResources([
    '/categories' => CategoryController::class,
]);