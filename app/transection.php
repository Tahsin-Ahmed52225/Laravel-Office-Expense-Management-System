<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transection extends Model
{
    protected $table = 'transection';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount', 'type',
    ];

    public function User()
    {
        $this->belongsTo(User::class);
    }
    public function Salary()
    {
        return $this->hasMany(Salary::class);
    }
    public function Expense()
    {
        return $this->hasMany(Expense::class);
    }
    public function Gain()
    {
        return $this->hasMany(Gain::class);
    }
    public function notification()
    {
        return $this->hasMany(notification::class);
    }
    public function advance()
    {
        return $this->hasMany(advance::class);
    }
}
