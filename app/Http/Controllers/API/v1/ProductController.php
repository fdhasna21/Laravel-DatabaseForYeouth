<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\CategoryGroup;
use App\Models\MainProduct;
use App\Models\VersionProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //TODO : belum bisa masukin versionproduct ke array mainproduct-nya
    public function all(){
        return response(['product' => MainProduct::all()]);
    }

    public function each(Request $request){
        $request->validate([
            'product_id' => 'required_without:version_id',
            'version_id' => 'required_without:product_id'
        ]);

        //TODO : ambil product berdasarkan version_id
        if(isset($request->product_id)){
            return response(['product' => array(MainProduct::where('product_id', '=', $request->product_id)->first())]);
        }
    }

    public function byCategory(Request $request){
        $request->validate([
            'group'=>'required_without:merchandise',
            'merchandise'=>'required_without:group'
        ]);

        //TODO : ambil productnya di limit
        if(isset($request->group) && !isset($request->merchandise)){
            return response(['product' => MainProduct::where('product_group_id', '=', $request->group)->get()]);
        }
        else if(!isset($request->group) && isset($request->merchandise)){
            return response(['product' => MainProduct::where('product_merchandise_id', '=', $request->merchandise)->get()]);
        }
        else if(isset($request->group) && isset($request->merchandise)){
            return response(['product' => MainProduct::where('product_group_id', '=', $request->group)
                                ->where('product_merchandise_id', '=', $request->merchandise)->get()]);
        }
    }

    public function byKeyword(Request $request){
        $keyword = $request->keyword;
        return response(['product' => MainProduct::where('product_name', 'LIKE', "%$keyword%")
                        ->orwhere('product_category', 'LIKE', "%$keyword%")
                        ->orwhere('product_detail', 'LIKE', "%$keyword%")
                        ->get()]);
    }

    public function each2(Request $request){
        $request->validate([
            'product_id' => 'required_without:version_id',
            'version_id' => 'required_without:product_id'
        ]);

        // $product = MainProduct::where('product_id', '=', $request->product_id)->get();
        // // $version = VersionProduct::where('version_product_id', '=', $request->product_id)->get();
        // foreach ($product as $eachversion) {
        //     echo $eachversion->versionProducts->first();
        //     // VersionProduct::where('version_product_id', '=', $request->product_id)->get();
        // }
        // return response(['product' => $product]);

        $product = MainProduct::where('product_id', '=', $request->product_id)->get();
        foreach ($product as $eachversion) {
            echo $eachversion->versionProducts;
            // VersionProduct::where('version_product_id', '=', $request->product_id)->get();
        }
        return response(['products' => $product]);
    }

    public function byGroup(CategoryGroup $group){
        $product=$group->mainProducts;
        return response(['product'=> $product]);
    }
}
