<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'title',
        'image',
        'address',
        'phone',
        'dob',
        'gender',
        'email',
        'email_verified_at',
        'password',
        'isAdmin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function note() {
        return $this->hasOne('App\Note');
    }

    public function todo() {
        return $this->hasOne('App\Todo');
    }

    public function timings() {
        return $this->hasMany('App\Timing');
    }

    public function invoices() {
        return $this->hasMany('App\Invoice');
    }
}
