<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\ShoppingbagController;
use App\Http\Controllers\API\v1\UserDetailController;
use App\Http\Controllers\API\v1\UserActivationController;

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

//Post : data di Body
//Get : data di Param

//UserActivationController
Route::post('/v1/regis', [UserActivationController::class, 'register']);
Route::post('/v1/login', [UserActivationController::class, 'login']);
Route::middleware('auth:api')->get('/v1/logout', [UserActivationController::class, 'logout']);

//UserDetailController
Route::middleware('auth:api')->get('/v1/show', [UserDetailController::class, 'show']);
Route::middleware('auth:api')->post('/v1/update', [UserDetailController::class, 'update']);

//CategoryController
Route::middleware('auth:api')->get('/v1/category', [CategoryController::class, 'show']);

//ProductController
Route::middleware('auth:api')->get('/v1/product/all', [ProductController::class, 'all']);
Route::middleware('auth:api')->get('/v1/product/search', [ProductController::class, 'allByKeyword']);
Route::middleware('auth:api')->get('/v1/product/category', [ProductController::class, 'allByCategory']);
Route::middleware('auth:api')->get('/v1/product={product_id}', [ProductController::class, 'eachByProductID']);
Route::middleware('auth:api')->get('/v1/product/version={version_id}', [ProductController::class, 'eachByVersionID']);

//ShoppingbagController
Route::middleware('auth:api')->post('/v1/shoppingbag/add', [ShoppingbagController::class, 'add']);
Route::middleware('auth:api')->post('/v1/shoppingbag/delete', [ShoppingbagController::class, 'delete']);
Route::middleware('auth:api')->get('/v1/shoppingbag/show', [ShoppingbagController::class, 'show']);
