<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code', 'name', 'price', 'stock',
        'minimum_stock', 'description', 'status', 'image',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }

    public function detail_purchases()
    {
        return $this->hashMany('App\Models\DetailPurchase');
    }
}
