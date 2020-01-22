<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceCart extends Model
{
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}
