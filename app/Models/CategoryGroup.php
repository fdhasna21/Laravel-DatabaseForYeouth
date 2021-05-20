<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    use HasFactory;

    //1 CategoryGroup : many ProductMain
    public function mainProducts(){
        return $this->hasMany(ProductMain::class);
    }
}
