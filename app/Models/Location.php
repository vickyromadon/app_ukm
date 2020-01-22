<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'address', 'sub_district', 'district', 'province'
    ];

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

    public function suppliers()
    {
        return $this->hasMany('App\Models\Supplier');
    }

    public function seller()
    {
        return $this->hasOne('App\Models\Seller');
    }
}
