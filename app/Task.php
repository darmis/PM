<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'startdate',
        'status',
        'project_id',
        'members'
    ];

    protected $casts = [
        'members' => 'json'
    ];

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function timings() {
        return $this->hasMany('App\Timing');
    }
}
