<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'phone', 'region_id', 'image', 'activate','pin_code');

    public function tokens()
    {
      return $this->morphMany('App\Models\Token', 'tokenable');
    }
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }


    protected $hidden = [
        'password', 'api_token',
    ];

}
