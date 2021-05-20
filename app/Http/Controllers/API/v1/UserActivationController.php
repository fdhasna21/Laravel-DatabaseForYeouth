<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserActivationController extends Controller
{
    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', '=' , $email)->first();
        if($user != null){
            if(Hash::check($password, $user->password)){
                $user->api_token = Str::random(60);
                $user->save();
                return response(['token' => $user->api_token]);
            }
            else{
                return response(['error' => 'The email and password you entered did not match.'], 401);
            }
        }
        else{
            return response(['error' => 'Email is not registered.'], 401);
        }
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return response(['success'=> true]);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed' //will automatically check with password_confirmation
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email_verified_at= now();
        $user->remember_token= Str::random(10);
        $user->save();

        return response(['success'=> true]);
    }
}
