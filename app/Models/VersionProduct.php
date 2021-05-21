<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionProduct extends Model
{
    use HasFactory;
    //1 VersionProduct : 1 MainProduct, 1 ShoppingBag

    public function mainProduct(){
        return $this->belongsTo(MainProduct::class);
    }

    public function shoppingbag(){
        return $this->belongsTo(Shoppingbag::class);
    }
}
