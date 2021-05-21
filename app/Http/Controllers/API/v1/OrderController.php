<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //TODO : do this!

    public function add(Request $request){
        //add to order_status, process status, and add shopping_id that related to this record
    }

    public function show(Request $request){
        //show order by status for each user (each statuses)
        //history : completed order
        //processed : processed by vendor
        //shipping
    }

    public function updateStatus(Request $request){
        //to update status as tracking shipping
    }
}
