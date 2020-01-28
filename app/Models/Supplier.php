<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'code', 'name', 'email', 'phone', 'status'
    ];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function purcahses()
    {
        return $this->hasMany('App\Models\Purchase');
    }

    public function report_purchases()
    {
        return $this->hasMany('App\Models\ReportPurchase');
    }
}
