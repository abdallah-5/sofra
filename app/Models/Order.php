<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id', 'status', 'payment_method_id', 'cost', 'delivery_cost', 'total', 'commission', 'notes', 'address', 'special_order');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');//->withPivot('quantity','price','notes');
    }

}
