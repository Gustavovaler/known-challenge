<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected  $fillable = ['ref_id','product_id' ,  'name' ,  'quantity' ,  'order_id' , 'original_order_id'];
}
