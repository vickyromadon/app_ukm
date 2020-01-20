<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSelling extends Model
{
    protected $fillable = [
        'code', 'quantity', 'price', 'total', 'status'
    ];

    public function selling()
    {
        return $this->belongsTo('App\Models\Selling');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
