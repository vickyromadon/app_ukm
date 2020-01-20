<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPurchase extends Model
{
    protected $fillable = [
        'code', 'quantity', 'price', 'total', 'status'
    ];

    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
