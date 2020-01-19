<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function suppliers()
    {
        return $this->hasMany('App\Models\Supplier');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function purcahses()
    {
        return $this->hasMany('App\Models\Purchase');
    }

    public function sellings()
    {
        return $this->hasMany('App\Models\Selling');
    }
}
