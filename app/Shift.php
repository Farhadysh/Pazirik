<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    const ACTIVE = 1;
    const NOT_ACTIVE = 2;

    protected $fillable = [
        'from', 'to', 'active'
    ];

    public function getActiveAttribute($value)
    {
        switch ($value) {
            case Shift::ACTIVE:
                return 'فعال';
                break;
            case Shift::NOT_ACTIVE:
                return 'غیر فعال';
                break;
        }
    }
}
