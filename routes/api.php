<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\UserCRUDController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, "login"]);
Route::post('signup', [AuthController::class, "signup"]);

Route::middleware("auth:sanctum")->group(function(){

    Route::apiResource("user", UserCRUDController::class);

    Route::apiResource("company", CompanyController::class);

    Route::post('logout', [AuthController::class, "logout"]);
});