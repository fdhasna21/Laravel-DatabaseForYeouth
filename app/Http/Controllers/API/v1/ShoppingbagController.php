<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Shoppingbag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainProduct;
use App\Models\VersionProduct;

class ShoppingbagController extends Controller
{
    public function add(Request $request){
        $user = $request->user();
        $request->validate([
            'sb_id' => 'exists:shoppingbags,id',
            'ver_id' => 'required',
            'qty'=> 'required|numeric'
        ]);

        if(isset($request->sb_id))
        {
            $sb = Shoppingbag::where('id', '=', $request->sb_id)->first();
        }
        else{
            $sb = new Shoppingbag();
            $sb->user_id = $user->id;
        }

        $sb->version_product_id = $request->ver_id;
        $sb->shoppingbag_quantity = $request->qty;
        $sb->save();

        return response(['success' => true]);
    }

    public function delete(Request $request){
        $user = $request->user();
        $request->validate([
            'sb_id' => 'required|exists:shoppingbags,id'
        ]);

        $sb = Shoppingbag::where('user_id', '=', $user->id)->find($request->sb_id);
        if($sb){
            $sb->delete();
            return response(['success' => true]);
        }
        else{
            return response(['error' => "The given sb_id is not belong to $user->email"],401);
        }
    }

    public function show(Request $request){
        $user = $request->user();

        $sb = Shoppingbag::where('user_id', '=', $user->id)
                ->where('order_info_id', null)->get();

        foreach($sb as $eachVersion){
            $version_id = $eachVersion->version_product_id;
            $version = VersionProduct::find($version_id);
            $product = MainProduct::where('id', '=', $version->main_product_id)->first();
            $eachVersion->product_detail = collect([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'version_id' => $version->id,
                'version_name' => $version->version_name,
                'version_stock' => $version->version_stock
                ]);
        }

        $sb->makeHidden(['order_info_id', 'user_id', 'version_product_id','created_at', 'updated_at']);
        return response(['shoppingbag' => $sb]);
    }
}
