<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserWishlist extends Model
{
    use HasFactory;
    public $timestamps = false;

    //1 UserWishlist : 1 User, 1 MainProduct
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mainProduct(){
        return $this->belongsTo(MainProduct::class);
    }
}
