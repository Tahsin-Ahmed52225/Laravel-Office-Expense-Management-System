<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $table = 'notification';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_ID', 'transection_ID', 'expense_ID', 'notification', 'type',
    ];
}
