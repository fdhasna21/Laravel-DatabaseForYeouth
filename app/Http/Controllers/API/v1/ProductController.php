<?php

namespace App\Http\Controllers\API\v1;

use App\Models\MainProduct;
use Illuminate\Http\Request;
use App\Models\VersionProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //TODO : make JSON output without version_products(main_product_id, created_at, updated_at)
    public function all(){
        $products = MainProduct::with('versionProducts')->get();
        return response(['total'=> $products->count(),'product' => $products]);
    }

    public function allByCategory(Request $request){
        $request->validate([
            'group' =>'required_without:merchandise',
            'merchandise' =>'required_without:group',
            'limit' => 'numeric'
        ]);

        $all = DB::table('main_products');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $all->count();
        }

        if(isset($request->group) && !isset($request->merchandise)){
            $products = MainProduct::where('category_group_id', '=', $request->group)
                                     ->take($limit)->with('versionProducts')->get();
        }
        else if(!isset($request->group) && isset($request->merchandise)){
            $products = MainProduct::where('category_merchandise_id', '=', $request->merchandise)
                                    ->take($limit)->with('versionProducts')->get();
        }
        else{
            $products = MainProduct::where('category_group_id', '=', $request->group)
                                    ->where('category_merchandise_id', '=', $request->merchandise)
                                    ->take($limit)->with('versionProducts')->get();
        }
        return response(['total' => $products->count(), 'product' => $products]);
    }

    public function allByKeyword(Request $request){
        $keyword = $request->keyword;
        $products = MainProduct::where('product_name', 'LIKE', "%$keyword%")
                                    ->orwhere('product_category', 'LIKE', "%$keyword%")
                                    ->orwhere('product_detail', 'LIKE', "%$keyword%")
                                    ->with('versionProducts')->get();
        return response(['total' => $products->count(), 'product' => $products]);
    }

    public function eachByProductID(MainProduct $product_id){
        return response(['product'=>$product_id->with('versionProducts')->find($product_id->id)]);
    }

    public function eachByVersionID(VersionProduct $version_id){
        $product_by_version = $version_id->main_product_id;
        return response(['product'=>MainProduct::with('versionProducts')->find($product_by_version)]);
    }
}

    // Show each product with paremeter (mechanism is provided in separate functions)
    // public function each(Request $request){
    //     $request->validate([
    //         'product_id' => 'required_without:version_id',
    //         'version_id' => 'required_without:product_id'
    //     ]);

    //     if(isset($request->product_id)){
    //         return response(['product' => MainProduct::where('id', '=', $request->product_id)->with('versionProducts')->get()]);
    //     }
    //     if(isset($request->version_id)){
    //         $product_by_version = VersionProduct::where('id', '=', $request->version_id)->value('id');
    //         return response(['product' => MainProduct::where('id', '=', $product_by_version)->with('versionProducts')->get()]);
    //     }
    // }
