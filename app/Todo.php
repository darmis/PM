<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id',
        'todo'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
