<?php

namespace App\Http\Controllers\API\v1;

use App\Models\MainProduct;
use App\Models\Shoppingbag;
use Illuminate\Http\Request;
use App\Models\VersionProduct;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class ShoppingbagController extends Controller
{
    public function shoppingbagEachUser($user){
        $sb = Shoppingbag::where('user_id',  $user->id)
                ->where('order_info_id', null)
                ->orderBy('updated_at', 'DESC')
                ->get();
        $sb->makeHidden(['order_info_id', 'user_id', 'version_product_id','created_at', 'updated_at']);
        return $sb;
    }

    public function add(Request $request){
        $user = $request->user();
        $request->validate([
            'sb_id' => 'exists:shoppingbags,id',
            'ver_id' => 'required',
            'qty'=> 'required|numeric'
        ]);

        if(isset($request->sb_id))
        {
            $sb = Shoppingbag::where('user_id',  $user->id)->find($request->sb_id);
        }
        else
        {
            $version = Shoppingbag::where('user_id',  $user->id)
                                ->where('version_product_id',  $request->ver_id)->get();
            $new_data = true;
            foreach($version as $eachVersion){
                if($eachVersion->order_info_id == null)
                {
                    $sb = $eachVersion;
                    $new_data = false;
                    break;
                }
            }

            if($new_data == true){
                $sb = new Shoppingbag();
                $sb->user_id = $user->id;
                $sb->version_product_id = $request->ver_id;
            }
        }

        $stock = VersionProduct::find($request->ver_id);
        $sb->shoppingbag_quantity += $request->qty;
        $sb->product_price = $stock->version_price;
        $stock->version_stock -= $request->qty;

        $stock->save();
        $sb->save();

        return response(['success' => true]);
    }

    public function delete(Request $request){
        $user = $request->user();
        $request->validate([
            'sb_id' => 'required|exists:shoppingbags,id'
        ]);

        $sb = Shoppingbag::where('user_id',  $user->id)
                            ->where('order_info_id',  null)->find($request->sb_id);

        if($sb){
            $sb->delete();
            $version_table = VersionProduct::find($sb->version_product_id);
            $version_table->version_stock += $sb->shoppingbag_quantity;
            $version_table->save();
            return response(['success' => true]);
        }
        else{
            return response(['error' => "Cannot delete the related record."],401);
        }
    }

    public function show(Request $request){
        $user = $request->user();

        $sb = $this->shoppingbagEachUser($user);

        foreach($sb as $eachVersion){
            $version_id = $eachVersion->version_product_id;
            $version = VersionProduct::find($version_id);
            $product = MainProduct::find($version->main_product_id);
            $eachVersion->product_detail = collect([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'product_category' => $product->product_category,
                'version_id' => $version->id,
                'version_name' => $version->version_name,
                'version_stock' => $version->version_stock
                ]);
        }

        return response(['total'=> $sb->count(),'shoppingbag' => $sb]);
    }
}
