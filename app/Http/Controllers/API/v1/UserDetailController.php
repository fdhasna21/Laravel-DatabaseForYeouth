<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserDetail;

class UserDetailController extends Controller
{
    public function show(Request $request){
        $user = $request->user();
        $user->userDetail->makeHidden(['id','user_id','created_at', 'updated_at']);
        $user->makeHidden(['email_verified_at']);
        return response($user);
    }

    public function update(Request $request){
        $userID = $request->user()->id;
        $detail = UserDetail::where('user_id',  $userID)->first();
        $request->validate([
            'address' => '',
            'phone' => 'numeric'
        ]);

        if(isset($request->address)){
            $detail->user_address = $request->address;
        }
        if(isset($request->phone)){
            $detail->user_phone = $request->phone;
        }
        $detail->save();
        // $user = User::where()
        return response(['success' => true]);
    }
}

    //Already auto create UserDetail in UserActivationController (regis)
    // public function create(Request $request){
    //     $userID = $request->user()->id;
    //     $request->validate([
    //         'address' => 'required',
    //         'phone' => 'required|numeric'
    //     ]);

    //     $detail = new UserDetail();
    //     $detail->user_address = $request->address;
    //     $detail->user_phone = $request->phone;
    //     $detail->user_id = $userID;
    //     $detail->save();
    //     return response(['success' => true]);
    // }
