<?php

namespace App\Models;

use App\Http\Traits\StringAsPrimary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    use HasFactory, StringAsPrimary;
    protected $primary_key  = 'group_id';

    //1 CategoryGroup : many ProductMain
    public function mainProducts(){
        return $this->hasMany(ProductMain::class, 'product_group_id', 'group_id');
    }
}
