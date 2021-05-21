<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shoppingbag extends Model
{
    use HasFactory;
    //1 Shoppingbag : 1 User, 1 OrderStatus, many VersionProduct

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderInfo(){
        return $this->belongsTo(OrderInfo::class);
    }

    public function versionProducts(){
        return $this->hasMany(VersionProduct::class);
    }

    public function productDetail(){
        return $this->productDetail;
    }
}
