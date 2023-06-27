<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParcelController;
use App\Models\User;

// use App\Http\Controllers\AssignmentController;

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

Route::get('/ll', function(){
    return User::all();
});
// User routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/parcels', [ParcelController::class, 'index']);
    Route::post('/parcels', [ParcelController::class, 'store']);
    Route::get('/auth/parcels', [ParcelController::class, 'get']);
    Route::middleware('biker')->group(function () {
        Route::put('/parcels/pick/{parcel}', [ParcelController::class, 'pickupParcel']);
        // Route::put('/biker-parcels/{id}', [AssignmentController::class, 'updateStatus']);
    });
    // Route::middleware('sender')->group(function () {
    //     Route::get('/users', [UserController::class, 'index']);
    //     Route::post('/users', [UserController::class, 'store']);
    //     Route::get('/users/{id}', [UserController::class, 'show']);
    //     Route::put('/users/{id}', [UserController::class, 'update']);
    //     Route::delete('/users/{id}', [UserController::class, 'destroy']);

    //     Route::get('/parcels', [ParcelController::class, 'index']);
    //     Route::post('/parcels', [ParcelController::class, 'store']);
    //     Route::get('/parcels/{id}', [ParcelController::class, 'show']);
    //     Route::put('/parcels/{id}', [ParcelController::class, 'update']);
    //     Route::delete('/parcels/{id}', [ParcelController::class, 'destroy']);
    // });
    
});

// Login route
Route::post('/login', [AuthController::class, 'login']);
Route::get('/all-users', function(){
    return User::all();
});
