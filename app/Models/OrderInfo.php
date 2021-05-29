<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderInfo extends Model
{
    use HasFactory;
    public $timestamps = false;

    //1 OrderStatus : many Shoppingbags, 1 User
    public function shoppingbags(){
        return $this->hasMany(Shoppingbag::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
