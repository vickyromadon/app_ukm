<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    protected $fillable = [
        'number', 'description', 'status', 'date'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product_assemblies()
    {
        return $this->hasMany('App\Models\ProductAssembly');
    }

    public function detail_assemblies()
    {
        return $this->hasMany('App\Models\DetailAssembly');
    }
}
