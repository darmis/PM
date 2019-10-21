<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
