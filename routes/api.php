<?php

use App\Http\Controllers\Api\ArisanGroupController;
use App\Http\Controllers\Api\Login\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/arisan', [ArisanGroupController::class, 'viewArisan']);


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/arisanGroup/{id}/join', [ArisanGroupController::class, 'joinById']);
    Route::resource('/arisanGroup', ArisanGroupController::class);
    Route::post('/logout', [AuthController::class, 'logout']);

    

    // contrack addres
    // Route::post('/arisan-groups/{id}/save-contract', [ArisanGroupController::class, 'saveContractAddress']);
    Route::post('/arisanGroup/{id}/contract-address', [ArisanGroupController::class, 'saveContractAddress']);

});

