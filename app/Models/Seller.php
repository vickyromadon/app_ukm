<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'phone', 'status'
    ];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Document');
    }

    public function carts()
    {
        return $this->hashMany('App\Models\Cart');
    }

    public function invoices()
    {
        return $this->hashMany('App\Models\Invoice');
    }
}
