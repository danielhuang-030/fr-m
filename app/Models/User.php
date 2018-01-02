<?php

namespace App\Models;

use App\Mail\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active_token', 'is_active', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * rewrite send reset password email
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->send(new ResetPassword($token));
    }
}
