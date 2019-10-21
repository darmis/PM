<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'startdate',
        'status',
        'creator_id',
        'members'
    ];

    protected $casts = [
        'members' => 'json'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function tasks() {
        return $this->hasMany('App\Task');
    }
}
