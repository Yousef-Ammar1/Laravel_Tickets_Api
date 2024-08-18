<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('authors', AuthorsController::class);
});


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('authors.tickets', AuthorTicketsController::class);
});
