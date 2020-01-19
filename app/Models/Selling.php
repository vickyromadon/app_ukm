<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    protected $fillable = [
        'number', 'date', 'description'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function detail_sellings()
    {
        return $this->hashMany('App\Models\DetailSelling');
    }
}
