<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'quantity', 'price', 'status'
    ];

    public function seller()
    {
        return $this->hasOne('App\Models\Seller');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function invoice_carts()
    {
        return $this->hasMany('App\Models\InvoiceCart');
    }
}
