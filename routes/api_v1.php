<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class);
});
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UsersController::class);
});
