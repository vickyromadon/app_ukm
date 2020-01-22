<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name', 'number', 'owner'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function seller()
    {
        return $this->hasOne('App\Models\Seller');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
