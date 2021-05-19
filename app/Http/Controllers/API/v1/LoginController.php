<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        //Get email and password from front end using Request Http
        $in_email = $request->email;
        $in_password = $request->password;

        //Get a record from Users table using User Model based on $in_email
        //this command equivalent with-> SELECT * FROM User WHERE 'email' = $in_email
        //Using first() for 1 data (by default it'll return first/last data depend on order type), get() for many datas
        $user = User::where('email', '=' , $in_email)->first();
        if($user != null){
            if(Hash::check($in_password, $user->password)){
                //$in_password match, so update api_token and save it into database
                $user->api_token = Str::random(60);
                $user->save();
                return response(['token' => $user->api_token]);
            }
            else{
                //$in_password don't match with hashed password in database
                return response(['error' => 'The email and password you entered did not match.'], 401);
            }
        }
        else{
            //$in_email don't match in database, so it'll return error
            return response(['error' => 'Email is not registered.'], 401);
        }
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return response(['success'=> true], 200);
    }
}
