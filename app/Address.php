<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'user_id','address', 'address_index','receive_address','description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
