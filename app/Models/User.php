<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * column that hidden from SELECT * in SQL
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //1 User : 1 UserDetail, many UserWishlist, 1 Image, many Shoppingbag, many OrderStatus
    public function userDetail(){
        return $this->hasOne(UserDetail::class);
    }

    public function userWishlists(){
        return $this->hasMany(UserWishlist::class);
    }

    public function image(){
        return $this->hasOne(Image::class);
    }

    public function shoppingbags(){
        return $this->hasMany(Shoppingbag::class);
    }

    public function orderInfos(){
        return $this->hasMany(OrderInfo::class);
    }
}
