<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStock extends Model
{
    protected $fillable = [
        'type', 'transaction_number', 'quantity_in', 'cogs_in', 'quantity_out', 'cogs_out', 'quantity_avg', 'cogs_avg', 'quantity_initial', 'price_initial'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
