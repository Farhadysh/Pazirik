<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $fillable = [
        'status', 'title', 'active', 'text'
    ];
}
