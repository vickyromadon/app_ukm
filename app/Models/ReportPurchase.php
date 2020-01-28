<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportPurchase extends Model
{
    protected $fillable = [
        'quantity', 'price', 'number'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
