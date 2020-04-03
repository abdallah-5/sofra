<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'phone', 'whatsapp', 'region_id', 'image', 'minimum_order', 'delivery_charge', 'available', 'activate', 'contact_phone','pin_code');

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }
    protected $hidden = [
        'password', 'api_token',
    ];
}
