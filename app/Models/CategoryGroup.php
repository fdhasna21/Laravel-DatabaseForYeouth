<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryGroup extends Model
{
    use HasFactory;

    //1 CategoryGroup : many ProductMain, many Image
    public function mainProducts(){
        return $this->hasMany(MainProduct::class);
    }

    public function image(){
        return $this->hasOne(Image::class);
    }
}
