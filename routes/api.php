<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\CategoryFeedController;
use App\Http\Controllers\API\v1\ImageController;
use App\Http\Controllers\API\v1\OrderController;
use App\Http\Controllers\API\v1\ShoppingbagController;
use App\Http\Controllers\API\v1\UserDetailController;
use App\Http\Controllers\API\v1\UserActivationController;
use App\Http\Controllers\API\v1\UserWishlistController;

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
Route::post('/v1/user/regis', [UserActivationController::class, 'register']);
Route::post('/v1/user/login', [UserActivationController::class, 'login']);
Route::middleware('auth:api')->get('/v1/user/logout', [UserActivationController::class, 'logout']);

//UserDetailController
Route::middleware('auth:api')->get('/v1/user/show', [UserDetailController::class, 'show']);
Route::middleware('auth:api')->post('/v1/user/update', [UserDetailController::class, 'update']);

//UserWishlistController
Route::middleware('auth:api')->post('v1/wishlist/add={product_id}', [UserWishlistController::class, 'add']);
Route::middleware('auth:api')->get('v1/wishlist/show', [UserWishlistController::class, 'show']);

//ImageController
Route::middleware('auth:api')->post('v1/image/add', [ImageController::class, 'add']);
Route::middleware('auth:api')->post('v1/image/delete', [ImageController::class, 'delete']);

//CategoryFeedController
Route::middleware('auth:api')->get('/v1/category', [CategoryFeedController::class, 'show']);
Route::middleware('auth:api')->get('/v1/feeds', [CategoryFeedController::class, 'allFeeds']);
Route::middleware('auth:api')->get('/v1/feed/newCollection', [CategoryFeedController::class, 'feedNewCollection']);
Route::middleware('auth:api')->get('/v1/feed/trendingMerchandise', [CategoryFeedController::class, 'freedTrendingMerchandise']);
Route::middleware('auth:api')->get('/v1/feed/bestSeller', [CategoryFeedController::class, 'feedBestSeller']);

//ProductController
Route::middleware('auth:api')->get('/v1/products', [ProductController::class, 'products']);
Route::middleware('auth:api')->get('/v1/product/all', [ProductController::class, 'all']);
Route::middleware('auth:api')->get('/v1/product/search', [ProductController::class, 'allByKeyword']);
Route::middleware('auth:api')->get('/v1/product/category', [ProductController::class, 'allByCategory']);
Route::middleware('auth:api')->get('/v1/product/version={version}', [ProductController::class, 'eachByVersionID']);
Route::middleware('auth:api')->get('/v1/product={product}', [ProductController::class, 'eachByProductID']);

//ShoppingbagController : for related user only
Route::middleware('auth:api')->post('/v1/shoppingbag/add', [ShoppingbagController::class, 'add']);
Route::middleware('auth:api')->post('/v1/shoppingbag/delete', [ShoppingbagController::class, 'delete']);
Route::middleware('auth:api')->get('/v1/shoppingbag/show', [ShoppingbagController::class, 'show']);

//OrderController : for related user only
Route::middleware('auth:api')->post('/v1/checkout/add', [OrderController::class, 'add']);
Route::middleware('auth:api')->post('/v1/checkout/update={order}', [OrderController::class, 'updateStatus']);
Route::middleware('auth:api')->post('/v1/checkout/order={order}', [OrderController::class, 'showByOrderID']);
Route::middleware('auth:api')->post('/v1/checkout', [OrderController::class, 'showByStatus']);


    //TODO : doing this!
    // 1. add others algorithm (AdminController to add products, categories, etc.)
    // 2. delete user_id in order_info (should find a way to get user_id from shoppingbag)
    // 3. sort by rate for ProductController and sort by updated_at (shoppingbag) for OrderController (showByStatus)
    // 4. controller for image (add and delete)

    //TODO : find solution!
    // 1. array as an param at http request
