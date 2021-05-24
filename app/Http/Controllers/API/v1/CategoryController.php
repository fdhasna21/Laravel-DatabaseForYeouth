<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Models\CategoryGroup;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryMerchandise;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function show(Request $request){
        $request->validate([
            'by' => Rule::in(['group', 'merchandise', 'all']),
            'limit' => 'numeric'
        ]);

        $products = DB::table('main_products');
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        else{
            $limit = $products->count();
        }

        if($request->by == 'group'){
            return response(['group' => CategoryGroup::take($limit)->get()->makeHidden(['created_at', 'updated_at'])]);
        }
        else if($request->by  == 'merchandise'){
            return response(['merchandise'=>CategoryMerchandise::take($limit)->get()->makeHidden(['created_at', 'updated_at'])]);
        }
        else{
            return response(['merchandise'=> CategoryMerchandise::take($limit)->get()->makeHidden(['created_at', 'updated_at']),
                            'group'=>CategoryGroup::take($limit)->get()->makeHidden(['created_at', 'updated_at'])]);
        }
    }
}
