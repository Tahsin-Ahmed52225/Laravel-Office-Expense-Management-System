<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'name', 'email', 'password', 'verification_code', 'stage', 'role', 'is_verified', 'designation', 'department', 'salary', 'number',
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
    /**
     * Functions to determine Admin or User
     *
     * @return true/false
     */
    public function isAdmin()
    {
        if ($this->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }
    public function isUser()
    {
        if ($this->role == 'user') {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Functions to determine user is locked or Unlokced
     *
     * @return true/false
     */
    public function unLocked()
    {
        if ($this->stage == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function transection()
    {
        return $this->hasMany(transection::class);
    }
}
