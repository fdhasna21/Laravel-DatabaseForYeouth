<?php

namespace App\Http\Controllers\API\v1;

use App\Models\OrderInfo;
use App\Models\MainProduct;
use App\Models\Shoppingbag;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use App\Models\VersionProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class OrderController extends Controller
{
    private function showDetailOrders(Collection $orders){
        foreach($orders as $order){
            $this->showDetailOrder($order);
        }
        return $orders;
    }

    private function showDetailOrder(OrderInfo $order){
        $order->shoppingbags->makeHidden(['created_at', 'updated_at', 'user_id', 'order_info_id']);
        foreach($order->shoppingbags as $eachSb){
            $version = VersionProduct::find($eachSb->version_product_id);
            $product = MainProduct::find($version->main_product_id);
            $eachSb->product_detail = collect([
                'product_name' => $product->product_name,
                'product_category' => $product->product_category,
                'version_name' => $version->version_name]);
        }
        $order->makeHidden('user_id');
        return $order;
    }

    public function add(Request $request){
        //TODO : allow user to choose products for checkout
        $user = $request->user();
        $userDetail = $user->userDetail;
        //TODO : if userDetail->user_address and user_phone null, return error need those be filled. then in apps will direct to add userDetail XML

        $sb = new ShoppingbagController;
        $sb = $sb->shoppingbagEachUser($user);

        if(count($sb) > 0){
            $order = new OrderInfo();
            $order->user_id = $user->id;
            $order->order_receiver = implode("\n", [$user->name, $userDetail->user_address, $userDetail->user_phone]);
            $order->save();
            foreach($sb as $eachSb){
                $version_table = VersionProduct::where('id',  $eachSb->version_product_id)->find($eachSb->version_product_id);
                $product_id = $version_table->main_product_id;
                $product_table = MainProduct::where('id',  $product_id)->find($product_id);
                $eachSb->order_info_id = $order->id;
                $order->order_total += $eachSb->shoppingbag_quantity * $eachSb->product_price;
                $version_table->version_sold += $eachSb->shoppingbag_quantity;
                $product_table->product_sold += $eachSb->shoppingbag_quantity;
                $order->save();
                $eachSb->save();
                $version_table->save();
                $product_table->save();
            }
            return response(['success' => 'added']);
        }
        else{
            return response(['message' => 'nothing to add']);
        }
    }

    public function updateStatus(OrderInfo $order){
        //TODO : mechanism to validate who's updating user's order
        $status = $order->order_state;

        if($status == 'Processed'){
            $order->order_state= 'Shipping';
        }
        else if ($status == 'Shipping'){
            $order->order_state = 'Delivered';
        }
        else{
            return response(['message' => 'already delivered to receiver']);
        }

        $order->save();
        $sb = Shoppingbag::where('order_info_id', $order->id)->get();
        foreach($sb as $eachSb){
            $eachSb->updated_at = now();
            $eachSb->save();
        }
        return response(['success' => true]);
    }

    public function showByOrderID(Request $request, OrderInfo $order){
        $user = $request->user();
        $order_output = $order->where('user_id',  $user->id)->with('shoppingbags')
                                ->find($order->id);
        return response(['order'=> $this->showDetailOrder($order_output)]);
    }

    public function showByStatus(Request $request){
        $user = $request->user();
        $request->validate([
            'status' =>'required|in:Processed,Shipping,Delivered',
            'limit' => 'numeric'
        ]);

        $all = DB::table('order_infos');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $all->count();
        }

        $orders = OrderInfo::where('order_state',  $request->status)
                                ->where('user_id',  $user->id)
                                ->take($limit)
                                ->with('shoppingbags')
                                ->get();

        return response(['user_id' => $user->id,
                         'total' => $orders->count(),
                          'order' => $this->showDetailOrders($orders)]);
    }
}
