<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    //1 UserDetail : 1 User
    public function user(){
        return $this->hasOne(User::class);
    }
}
