<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gain extends Model
{
    protected $table = 'gain';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'transection_ID', 'amount', 'gain_details', 'remarks',
    ];
}
