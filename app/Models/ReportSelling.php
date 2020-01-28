<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSelling extends Model
{
    protected $fillable = [
        'type', 'quantity', 'price', 'number', 'customer_name'
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
