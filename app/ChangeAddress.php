<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeAddress extends Model
{
    protected $fillable = [
       'old_id','user_id','address', 'address_index','receive_address','description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function changeOrder()
    {
        return $this->belongsTo(ChangeOrder::class);
    }
}
