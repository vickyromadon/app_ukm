<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'number', 'description', 'status', 'date'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function detail_availabilities()
    {
        return $this->hasMany('App\Models\DetailAvailability');
    }
}
