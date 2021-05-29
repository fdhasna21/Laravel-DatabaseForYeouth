<?php

namespace App\Models;

use App\Models\MainProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $hidden = [
        'main_product_id',
        'version_product_id',
        'user_id',
        'category_group_id',
        'category_merchandise_id'
    ];
    //1 Image : 1 MainProduct, 1 VersionProduct, 1 User, 1 CategoryGroup, 1 CategoryMerchandise

    public function mainProduct(){
        return $this->belongsTo(MainProduct::class);
    }

    public function versionProduct(){
        return $this->belongsTo(VersionProduct::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function categoryGroup(){
        return $this->belongsTo(CategoryGroup::class);
    }

    public function categoryMerchandise(){
        return $this->belongsTo(CategoryMerchandise::class);
    }
}
