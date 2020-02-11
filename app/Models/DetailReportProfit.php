<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReportProfit extends Model
{
    protected $fillable = [
        'type', 'transaction_number', 'transaction_date', 'quantity_in', 'cogs_in', 'quantity_out', 'cogs_out', 'quantity_avg', 'cogs_avg',
    ];

    public function report_profit()
    {
        return $this->belongsTo('App\Models\ReportProfit');
    }
}
