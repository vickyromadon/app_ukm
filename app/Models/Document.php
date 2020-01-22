<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'photo', 'ktp', 'document'
    ];

    public function seller()
    {
        return $this->hasOne('App\Models\Seller');
    }
}
