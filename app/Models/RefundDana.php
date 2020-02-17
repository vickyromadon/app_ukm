<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundDana extends Model
{
    protected $fillable = [
        'nominal'
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }
}
