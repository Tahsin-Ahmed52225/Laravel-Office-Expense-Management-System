<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salary';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_ID', 'transection_ID', 'amount',
    ];
    public function transection()
    {
        $this->belongsTo(transection::class);
    }
}
