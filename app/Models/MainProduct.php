<?php

namespace App\Models;

use App\Models\Shoppingbag;
use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainProduct extends Model
{
    use HasFactory;

    //1 MainProduct : 1 CategoryGroup, 1 CategoryMerchandise, many VersionProduct
    public function categoryGroup(){
        return $this->belongsTo(CategoryGroup::class);
    }

    public function categoryMerchandise(){
        return $this->belongsTo(CategoryMerchandise::class);
    }

    public function versionProducts(){
        return $this->hasMany(VersionProduct::class);
    }
}
