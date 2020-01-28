<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAssembly extends Model
{
    protected $fillable = [
        'code', 'quantity', 'status'
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
