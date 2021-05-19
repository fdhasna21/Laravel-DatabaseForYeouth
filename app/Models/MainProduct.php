<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainProduct extends Model
{
    use HasFactory, StringAsPrimary;
    protected $primary_key  = 'product_id';

    //1 MainProduct : 1 CategoryGroup, 1 CategoryMerchandise, many VersionProduct
    public function categoryGroup(){
        return $this->belongsTo(CategoryGroup::class, 'product_group_id');
    }

    public function categoryMerchandise(){
        return $this->belongsTo(CategoryMerchandise::class, 'product_merchandise_id');
    }

    public function versionProducts(){
        return $this->hasMany(VersionProduct::class, 'product_version_id', 'version_id');
    }
}
