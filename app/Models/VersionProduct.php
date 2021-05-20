<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionProduct extends Model
{
    use HasFactory;
    //1 VersionProduct : 1 MainProduct
    //many VersionProduct : many Shoppingbag

    public function mainProduct(){
        return $this->belongsTo(MainProduct::class);
    }

    //TODO: benerin many-to-many di VersionProduct
    public function shoppingbags(){
        return $this->belongsToMany(Shoppingbag::class);
                    // ->withPivot('version_product_id', 'shoppingbag_quantity', 'version_stock', 'version_price')
    }
}
