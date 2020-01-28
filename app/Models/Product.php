<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code', 'name', 'price', 'stock',
        'minimum_stock', 'description',
        'status', 'image', 'selling_price'
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
        return $this->hasMany('App\Models\DetailPurchase');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function product_assembly()
    {
        return $this->hasMany('App\Models\ProductAssembly');
    }

    public function detail_assemblies()
    {
        return $this->hasMany('App\Models\DetailAssembly');
    }

    public function detail_availabilities()
    {
        return $this->hasMany('App\Models\DetailAvailability');
    }

    public function detail_sellings()
    {
        return $this->hasMany('App\Models\DetailSelling');
    }

    public function report_sellings()
    {
        return $this->hasMany('App\Models\ReportSelling');
    }

    public function report_purchases()
    {
        return $this->hasMany('App\Models\ReportPurchase');
    }

    public function report_stocks()
    {
        return $this->hasMany('App\Models\ReportStock');
    }
}
