<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Models\CategoryGroup;
use Illuminate\Validation\Rule;
use App\Models\CategoryMerchandise;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function show(Request $request){
        $request->validate([
            'by' => Rule::in(['group', 'merchandise', 'all'])
        ]);

        if($request->by == 'group'){
            return response(['group' => CategoryGroup::all()]);
        }
        else if($request->by == 'merchandise'){
            return response(['merchandise'=>CategoryMerchandise::all()]);
        }
        else{
            return response(['merchandise'=> CategoryMerchandise::all(),
                            'group'=>CategoryGroup::all()]);
        }
    }
}
