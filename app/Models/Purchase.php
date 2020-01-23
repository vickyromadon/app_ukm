<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'number', 'date', 'description', 'date'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function detail_purchases()
    {
        return $this->hashMany('App\Models\DetailPurchase');
    }
}
