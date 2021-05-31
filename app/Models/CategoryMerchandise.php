<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryMerchandise extends Model
{
    use HasFactory;

    //1 CategoryMerchandise : many ProductMain, many Image
    public function mainProducts(){
        return $this->hasMany(MainProduct::class)->take(2);
    }

    public function image(){
        return $this->hasOne(Image::class);
    }
}
