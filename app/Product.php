<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'level', 'price', 'unit','washCount','active'
    ];

    public function FactorProducts()
    {
        return $this->hasMany(FactorProduct::class);
    }
}
