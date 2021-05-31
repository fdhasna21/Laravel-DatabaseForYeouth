<?php

namespace App\Http\Controllers\API\v1;

use App\Models\MainProduct;
use Illuminate\Http\Request;
use App\Models\CategoryGroup;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryMerchandise;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class CategoryFeedController extends Controller
{
    private function byProductSold(Collection $categories, $limit, $string){
        foreach($categories as $category){
            if($string == "group"){
                $category->mainProducts = MainProduct::where('category_group_id',  $category->id)->orderBy('product_sold', 'DESC')->take($limit)->get();
            }
            else{
                $category->mainProducts = MainProduct::where('category_merchandise_id',  $category->id)->orderBy('product_sold', 'DESC')->take($limit)->get();
            }
            $category->mainProducts->makeHidden(['created_at', 'updated_at', 'product_detail', 'product_release', 'category_merchandise_id', 'category_group_id' ]);
        }
        return $categories;
    }

    public function show(Request $request){
        $request->validate([
            'by' => Rule::in(['group', 'merchandise']),
            'limit' => 'numeric'
        ]);

        $products = DB::table('main_products');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $products->count();
        }

        $groups = CategoryGroup::with('image')->get()->makeHidden(['created_at', 'updated_at', 'main_products', 'group_detail']);
        //$this->byProductSold($groups, $limit, "group");
        $merchandises = CategoryMerchandise::with('image')->get()->makeHidden(['created_at', 'updated_at']);
        //$this->byProductSold($merchandises, $limit, "merchandise");


        if($request->by == 'group'){
            return response(['groups' => $groups]);
        }
        else if($request->by  == 'merchandise'){
            return response(['merchandises'=> $merchandises]);
        }
        else{
            return response(['merchandises'=>$merchandises,
                            'groups'=> $groups]);
        }
    }

//FEEDS
    private function onlyPrice(Collection $products){
        foreach($products as $product){
            $product->versionProducts->makeHidden(['id', 'version_name', 'version_detail', 'version_price_created', 'version_stock', 'version_sold', 'created_at', 'updated_at', 'main_product_id']);
        }
        $products->makeHidden(['created_at', 'updated_at', 'product_detail', 'product_release', 'category_merchandise_id', 'category_group_id' ]);
        return $products;
    }

    public function allFeeds(Request $request){
        $request->validate([
            'limit' => 'numeric'
        ]);

        $products = DB::table('main_products');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $products->count();
        }

        $newCollection = MainProduct::with('versionProducts')->with('images')->orderBy('created_at', 'DESC')->take($limit)->get();
        $trendingMerchandise = MainProduct::with('versionProducts')->with('images')->orderBy('product_rate', 'DESC')->take($limit)->get();
        $bestSelller = MainProduct::with('versionProducts')->with('images')->orderBy('product_sold', 'DESC')->take($limit)->get();

        return response(["newCollection" => $this->onlyPrice($newCollection),
                         "trendingMerchandise" => $this->onlyPrice($trendingMerchandise),
                         "bestSeller" => $this->onlyPrice($bestSelller)]);
    }

    public function feedNewCollection(Request $request){
        $request->validate([
            'limit' => 'numeric'
        ]);

        $products = DB::table('main_products');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $products->count();
        }

        $products = MainProduct::with('versionProducts')->with('images')->orderBy('created_at', 'DESC')->take($limit)->get();
        foreach($products as $product){
            $product->versionProducts->makeHidden(['id', 'version_name', 'version_detail', 'version_price_created', 'version_stock', 'version_sold', 'created_at', 'updated_at', 'main_product_id']);
        }
        $products->makeHidden(['created_at', 'updated_at', 'product_detail', 'product_release', 'category_merchandise_id', 'category_group_id' ]);
        return response(['products' => $products]);
    }

    public function feedTrendingMerchandise(Request $request){
        $request->validate([
            'limit' => 'numeric'
        ]);

        $products = DB::table('main_products');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $products->count();
        }

        $products = MainProduct::with('versionProducts')->with('images')->orderBy('product_rate', 'DESC')->take($limit)->get();
        foreach($products as $product){
            $product->versionProducts->makeHidden(['id', 'version_name', 'version_detail', 'version_price_created', 'version_stock', 'version_sold', 'created_at', 'updated_at', 'main_product_id']);
        }
        $products->makeHidden(['created_at', 'updated_at', 'product_detail', 'product_release', 'category_merchandise_id', 'category_group_id' ]);
        return response(['products' => $products]);
    }

    public function feedBestSeller(Request $request){
        $request->validate([
            'limit' => 'numeric'
        ]);

        $products = DB::table('main_products');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $products->count();
        }

        $products = MainProduct::with('versionProducts')->with('images')->orderBy('product_sold', 'DESC')->take($limit)->get();
        foreach($products as $product){
            $product->versionProducts->makeHidden(['id', 'version_name', 'version_detail', 'version_price_created', 'version_stock', 'version_sold', 'created_at', 'updated_at', 'main_product_id']);
        }
        $products->makeHidden(['created_at', 'updated_at', 'product_detail', 'product_release', 'category_merchandise_id', 'category_group_id' ]);
        return response(['products' => $products]);
    }
}
