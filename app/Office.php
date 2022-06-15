<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'office_name', 'address', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
