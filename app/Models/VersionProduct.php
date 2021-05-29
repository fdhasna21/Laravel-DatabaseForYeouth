<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VersionProduct extends Model
{
    use HasFactory;
    //1 VersionProduct : 1 MainProduct, 1 ShoppingBag, many Image

    public function mainProduct(){
        return $this->belongsTo(MainProduct::class);
    }

    public function shoppingbag(){
        return $this->hasMany(Shoppingbag::class);
    }

    public function image(){
        return $this->hasMany(Image::class);
    }
}
