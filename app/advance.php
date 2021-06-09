<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class advance extends Model
{
    protected $table = 'advance';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_ID', 'transection_ID', 'amount', 'type'
    ];
    public function transection()
    {
        $this->belongsTo(transection::class);
    }
}
