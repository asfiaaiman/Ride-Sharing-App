<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'login_code',
        'remember_token',
    ];

    // phone number over which we need to send the login code
    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    // One to one relationship

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    // User can have multiple trips so one to many relationship is defined here
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
