<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number', 'status', 'total', 'subtotal', 'shipping', 'reason', 'receipt_number', 'receipt_type'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }

    public function invoice_carts()
    {
        return $this->hasMany('App\Models\InvoiceCart');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment');
    }
}
