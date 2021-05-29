<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\VersionProduct;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function add(Request $request){
        //TODO : validate request
        $userID = $request->user()->id;
        $request->validate([
            'url' => 'required|url'
            // 'prod_id' => 'exists:main_products,id|required_unless:group_id,any|required_unless:merch_id,any',
            // 'ver_id' => 'exists:version_products,id:required_unlessrequired_unless:group_id,any|required_unless:merch_id,any',
            // //'exists:version_products,id|required_unless:prod_id,any|required_unless:group_id,any|required_unless:merch_id,any',
            // //'group_id' => 'exists:category_products,id|required_unless:prod_id,any|required_unless:ver_id,any|required_unless:merch_id,any',
            // //'merch_id' => 'exists:merchandise_products,id|required_unless:prod_id,any|required_unless:ver_id,any|required_unless:group_id,any',
        ]);

        $image = new Image();
        $image->image_url = $request->url;
        if(isset($request->ver_id)){
            $image->version_product_id = $request->ver_id;
            $image->main_product_id = VersionProduct::where('id', $request->ver_id)->value('main_product_id');
        }
        else if(isset($request->prod_id)){
            $image->main_product_id = $request->prod_id;
        }
        else if(isset($request->group_id)){
            $image->category_group_id = $request->group_id;
        }
        else if(isset($request->merch_id)){
            $image->cateory_merchandise_id = $request->merch_id;
        }
        else{
            $exist = Image::where('user_id', $userID)->first();
            if($exist != null){
                $exist->delete();
            }
            $image->user_id = $userID;
        }
        $image->save();
        return response(['success' => true]);
    }

    public function delete(Request $request){
        //only delete user image
        $userID = $request->user()->id;
        $exist = Image::where('user_id', $userID)->first();
        if($exist != null){
            $exist->delete();
            return response(['success' => true]);
        }
        else{
            return response(['error' => 'nothing to delete'], 401);
        }
    }
}
