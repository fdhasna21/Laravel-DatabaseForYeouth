<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    //1 UserDetail : 1 User
    public function user(){
        return $this->hasOne(User::class);
    }
}
