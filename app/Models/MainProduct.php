<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainProduct extends Model
{
    use HasFactory;

    //1 MainProduct : 1 CategoryGroup, 1 CategoryMerchandise, many VersionProduct, many UserWishlist, many Image
    public function categoryGroup(){
        return $this->belongsTo(CategoryGroup::class);
    }

    public function categoryMerchandise(){
        return $this->belongsTo(CategoryMerchandise::class);
    }

    public function versionProducts(){
        return $this->hasMany(VersionProduct::class);
    }

    public function userWishlists(){ //can't be called in others
        return $this->hasMany(UserWishlist::class);
    }

    public function image(){
        return $this->hasMany(Image::class);
    }
}
