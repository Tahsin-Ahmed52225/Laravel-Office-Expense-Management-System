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
}
