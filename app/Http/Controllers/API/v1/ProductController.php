<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\CategoryGroup;
use App\Models\MainProduct;
use App\Models\VersionProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(){
        $products = MainProduct::with('versionProducts')->get();
        return response(['product' => $products]);
    }

    public function each(Request $request){
        $request->validate([
            'product_id' => 'required_without:version_id',
            'version_id' => 'required_without:product_id'
        ]);

        if(isset($request->product_id)){
            return response(['product' => MainProduct::where('id', '=', $request->product_id)->with('versionProducts')->get()]);
        }
        if(isset($request->version_id)){
            $product_by_version = VersionProduct::where('id', '=', $request->version_id)->value('id');
            return response(['product' => MainProduct::where('id', '=', $product_by_version)->with('versionProducts')->get()]);
        }
    }

    public function byCategory(Request $request){
        $request->validate([
            'group'=>'required_without:merchandise',
            'merchandise'=>'required_without:group'
        ]);

        //TODO : ambil productnya di limit
        if(isset($request->group) && !isset($request->merchandise)){
            return response(['product' => MainProduct::where('category_group_id', '=', $request->group)->with('versionProducts')->get()]);
        }
        else if(!isset($request->group) && isset($request->merchandise)){
            return response(['product' => MainProduct::where('category_merchandise_id', '=', $request->merchandise)->with('versionProducts')->get()]);
        }
        else if(isset($request->group) && isset($request->merchandise)){
            return response(['product' => MainProduct::where('category_group_id', '=', $request->group)
                                ->where('category_merchandise_id', '=', $request->merchandise)->with('versionProducts')->get()]);
        }
    }

    public function byKeyword(Request $request){
        $keyword = $request->keyword;
        return response(['product' => MainProduct::where('product_name', 'LIKE', "%$keyword%")
                        ->orwhere('product_category', 'LIKE', "%$keyword%")
                        ->orwhere('product_detail', 'LIKE', "%$keyword%")
                        ->with('versionProducts')->get()]);
    }
}
