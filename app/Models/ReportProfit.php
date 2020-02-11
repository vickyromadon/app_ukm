<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportProfit extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function detail_report_profits()
    {
        return $this->hasMany('App\Models\DetailReportProfit');
    }
}
