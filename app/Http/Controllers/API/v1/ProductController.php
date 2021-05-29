<?php

namespace App\Http\Controllers\API\v1;

use App\Models\MainProduct;
use Illuminate\Http\Request;
use App\Models\VersionProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    private function withoutVersionDetails(Collection $products){
        foreach($products as $product){
            $this->withoutVersionDetail($product);
        }
        return $products;
    }

    private function withoutVersionDetail(MainProduct $product){
        $product->versionProducts->makeHidden(['main_product_id', 'created_at', 'updated_at']);
        $product->makeHidden(['created_at', 'updated_at']);
        return $product;
    }

    public function all(){
        $products = MainProduct::with('versionProducts')->get();
        return response(['total'=> $products->count(),
                         'products' => $this->withoutVersionDetails($products)]);
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
            $products = MainProduct::where('category_group_id',  $request->group)
                                     ->take($limit)->with('versionProducts')->get();
        }
        else if(!isset($request->group) && isset($request->merchandise)){
            $products = MainProduct::where('category_merchandise_id',  $request->merchandise)
                                    ->take($limit)->with('versionProducts')->get();
        }
        else{
            $products = MainProduct::where('category_group_id',  $request->group)
                                    ->where('category_merchandise_id',  $request->merchandise)
                                    ->take($limit)->with('versionProducts')->get();
        }
        return response(['total'=> $products->count(),
                         'products' => $this->withoutVersionDetails($products)]);
    }

    public function allByKeyword(Request $request){
        $keyword = $request->keyword;
        $products = MainProduct::where('product_name', 'LIKE', "%$keyword%")
                                    ->orwhere('product_category', 'LIKE', "%$keyword%")
                                    ->orwhere('product_detail', 'LIKE', "%$keyword%")
                                    ->with('versionProducts')->get();
        return response(['total'=> $products->count(),
                         'products' => $this->withoutVersionDetails($products)]);
    }

    public function eachByProductID(MainProduct $product){
        $product_output = $product->with('versionProducts')->find($product->id);
        return response(['product'=> $this->withoutVersionDetail($product_output)]);
    }

    public function eachByVersionID(VersionProduct $version){
        $product_by_version = $version->main_product_id;
        $product_output = MainProduct::with('versionProducts')->find($product_by_version);
        return response(['product'=> $this->withoutVersionDetail($product_output)]);
    }
}
