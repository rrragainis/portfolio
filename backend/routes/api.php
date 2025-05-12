<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoshopController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ProgrammingController;
use App\Http\Controllers\ProgrammingPictureController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Resource Routes
Route::apiResource('photoshops', PhotoshopController::class);
Route::apiResource('audio', AudioController::class);
Route::apiResource('programmings', ProgrammingController::class);
Route::apiResource('programming-pictures', ProgrammingPictureController::class); 
