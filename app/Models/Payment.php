<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{

    protected $table = 'payments';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'paid', 'notes', 'next_payment');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}