<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $fillable = [
        'name', 'count', 'date', 'price','alert','description'
    ];
}
