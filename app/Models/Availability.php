<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'number', 'description', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
