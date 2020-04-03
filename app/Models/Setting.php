<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about_us', 'fb_link', 'inst_link', 'tw_link', 'commission', 'bank_account', 'cometion_text');

}