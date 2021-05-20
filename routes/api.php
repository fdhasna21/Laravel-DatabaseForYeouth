<?php

use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\UserActivationController;
use App\Http\Controllers\API\v1\UserDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//UserActivationController
Route::post('/v1/regis', [UserActivationController::class, 'register']);
Route::post('/v1/login', [UserActivationController::class, 'login']);
Route::middleware('auth:api')->get('/v1/logout', [UserActivationController::class, 'logout']);

//UserDetailController
Route::middleware('auth:api')->get('/v1/show', [UserDetailController::class, 'show']);
Route::middleware('auth:api')->post('/v1/create', [UserDetailController::class, 'create']);
Route::middleware('auth:api')->post('/v1/update', [UserDetailController::class, 'update']);

//CategoryController
Route::middleware('auth:api')->get('/v1/category', [CategoryController::class, 'show']);

//ProductController
Route::middleware('auth:api')->get('/v1/product/all', [ProductController::class, 'all']);
Route::middleware('auth:api')->get('/v1/product/each', [ProductController::class, 'each']);
Route::middleware('auth:api')->get('/v1/product/search', [ProductController::class, 'byKeyword']);
Route::middleware('auth:api')->get('/v1/product/category', [ProductController::class, 'byCategory']);
