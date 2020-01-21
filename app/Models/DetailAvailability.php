<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAvailability extends Model
{
    protected $fillable = [
        'code', 'quantity', 'status'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function availabilities()
    {
        return $this->belongsTo('App\Models\Availability');
    }
}
