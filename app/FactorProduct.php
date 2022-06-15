<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactorProduct extends Model
{
    protected $fillable = [
        'factor_id', 'product_id', 'count', 'price', 'defection', 'product_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function factor()
    {
        return $this->belongsTo(Factor::class);
    }
}
