<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\MainProduct;
use App\Models\UserWishlist;
use Illuminate\Http\Request;

class UserWishlistController extends Controller
{
    public function add(Request $request, MainProduct $product_id){
        $userID = $request->user()->id;

        $wishlist = UserWishlist::where('user_id', $userID)
                                ->where('main_product_id', $product_id->id)
                                ->first();

        if($wishlist == null){
            $wishlist = new UserWishlist();
            $wishlist->user_id = $userID;
            $wishlist->main_product_id = $product_id->id;
            $wishlist->save();

            $product_id->product_wishlisted += 1;
            $product_id->save();
            return response(['success' => 'added to wishlist']);
        }
        else{
            $product_id->product_wishlisted -=1;
            $product_id->save();
            $wishlist->delete();
            return response(['success' => 'removed from wishlist']);
        }
    }

    public function show(Request $request){
        $userID = $request->user()->id;
        $wishlists = UserWishlist::where('user_id', $userID)->orderBy('created_at', 'DESC')
                                    ->with('mainProduct')
                                    ->get();
        foreach($wishlists as $wishlist){
            $wishlist->mainProduct->makeHidden(['product_detail', 'product_release', 'product_wishlisted',
                                                'created_at', 'updated_at', 'category_merchandise_id',
                                                'category_group_id']);
        }

        return response(['user_id' => $userID,
                         'product_wishlisted' => $wishlists->makeHidden(['id', 'user_id', 'main_product_id'])]);
    }
}
