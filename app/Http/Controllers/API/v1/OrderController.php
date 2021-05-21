<?php

namespace App\Http\Controllers\API\v1;

use App\Models\OrderInfo;
use App\Models\Shoppingbag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Type\Integer;

class OrderController extends Controller
{
    public function add(Request $request){
        $user = $request->user();
        $userDetail = $user->userDetail;
        //TODO : update for order_total, if userDetail->user_address and user_phone null, return error need those be filled. then in apps will direct to add userDetail XML

        $sb = Shoppingbag::where('user_id', '=', $user->id)
                ->where('order_info_id', null)->get();

        if(count($sb) > 0){
            $order = new OrderInfo();
            $order->user_id = $user->id;
            $order->order_receiver = "$user->name";
            $order->save();
            foreach($sb as $eachSb){
                $eachSb->order_info_id = $order->id;
                $eachSb->save();
            }
            return response(['success' => 'added']);
        }
        else{
            return response(['message' => 'nothing to add']);
        }
    }

    public function updateStatus(OrderInfo $order_id){
        $status = $order_id->order_state;

        if($status == 'Processed'){
            $order_id->order_state= 'Shipping';
        }
        else if ($status == 'Shipping'){
            $order_id->order_state = 'Delivered';
        }
        else{
            return response(['message' => 'already delivered to receiver']);
        }

        $order_id->save();
        return response(['success' => true]);
    }

    public function showByOrderID(OrderInfo $order_id){
        return response(['order'=>$order_id->with('shoppingbags')->find($order_id->id)]);
    }


    public function showByStatus(Request $request){
        $user = $request->user();
        $request->validate([
            'status' =>'required|in:Processed,Shipping,Delivered',
            'limit' => 'numeric'
        ]);

        $orders = DB::table('order_infos');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $orders->count();
        }

        return response(['order' => OrderInfo::where('order_state', '=', $request->status)
                            ->where('user_id', '=', $user->id)
                            ->take($limit)
                            ->with('shoppingbags')->get()]);
    }
}
