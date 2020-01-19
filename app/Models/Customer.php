<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'code', 'name', 'email', 'phone', 'status'
    ];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function sellings()
    {
        return $this->hasMany('App\Models\Selling');
    }
}
