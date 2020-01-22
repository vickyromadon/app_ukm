<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'nominal', 'proof'
    ];

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
