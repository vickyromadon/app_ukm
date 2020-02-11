<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SideReportProfit extends Model
{
    protected $fillable = [
        'type', 'quantity_in', 'cogs_in', 'quantity_out', 'cogs_out', 'quantity_avg', 'cogs_avg',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
