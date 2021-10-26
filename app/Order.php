<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id' ,'payment_method_id',  'total_amount' , 'client_id' ];
}
