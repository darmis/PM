<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email'
    ];

    public function projects() {
        return $this->hasMany('App\Project');
    }

    public function invoices() {
        return $this->hasMany('App\Invoice');
    }
}
