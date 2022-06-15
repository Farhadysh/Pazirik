<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class ChangeFactor extends Model
{
    //    pay caash
    const TYPE_CASH = 1;
    const TYPE_debtor = 2;
    const TYPE_pos = 3;

    protected $fillable = [
        'old_id', 'factor_id', 'order_id', 'type', 'transport', 'collecting', 'service'
    ];

    public function getTypeAttribute($value)
    {
        switch ($value) {
            case Factor::TYPE_CASH:
                $data['title'] = 'پول نقد';
                $data['color'] = 'success';
                return $data;
                break;
            case Factor::TYPE_debtor:
                $data['title'] = 'اقساطی';
                $data['color'] = 'danger';
                return $data;
                break;
            case Factor::TYPE_pos:
                $data['title'] = 'کارتخوان';
                $data['color'] = 'warning';
                return $data;
                break;
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return Jalalian::forge($value)->format('H:i Y/m/d');
    }

    public function changeOrder()
    {
        return $this->belongsTo(ChangeOrder::class, 'order_id');
    }

    public function changeFactorProducts()
    {
        return $this->hasMany(ChangeFactorProduct::class, 'change_id');
    }
}
