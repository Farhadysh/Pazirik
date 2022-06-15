<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $fillable = [
        'price', 'date', 'cheque_number'
    ];

    public function debtor()
    {
        return $this->hasOne(Debtor::class);
    }
}
