<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    //1 OrderStatus : many Shoppingbags, 1 User
    public function shoppingbags(){
        return $this->hasMany(Shoppingbag::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
