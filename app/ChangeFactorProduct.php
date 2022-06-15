<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeFactorProduct extends Model
{
    protected $fillable = [
        'old_id','factor_id','product_id','count','price','defection','product_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function changeFactor()
    {
        return $this->belongsTo(ChangeFactor::class);
    }
}
