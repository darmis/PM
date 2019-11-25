<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'path',
        'projects',
        'tasks',
        'price',
        'payed'
    ];

    protected $casts = [
        'projects' => 'json',
        'tasks' => 'json'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
