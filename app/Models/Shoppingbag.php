<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppingbag extends Model
{
    use HasFactory, StringAsPrimary;
    protected $primary_key  = 'shoppingbag_id';
    //1 Shoppingbag : 1 User, 1 OrderStatus
    //many Shoppingbag : many VersionProduct

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderStatus(){
        return $this->belongsTo(OrderStatus::class, 'order_shoppingbag_id');
    }

    //TODO: benerin many-to-many di Shoppingbag
    public function versionProducts(){
        return $this->belongsToMany(VersionProduct::class, 'shoppingbag_version', 'shoppingbag_id', 'version_id');
    }
}
