<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timing extends Model
{
    protected $fillable = [
        'note',
        'task_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
    public function task() {
        return $this->belongsTo('App\Task');
    }
}
