<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAssembly extends Model
{
    protected $fillable = [
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function assembly()
    {
        return $this->belongsTo('App\Models\Assembly');
    }
}
