<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'order_id', 'status', 'description'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
