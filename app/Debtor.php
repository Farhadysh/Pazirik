<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    protected $fillable = [
        'factor_id', 'date', 'cost'
    ];

    public function factor()
    {
        return $this->belongsTo(Factor::class);
    }

    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }

}
