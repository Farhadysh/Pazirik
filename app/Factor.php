<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;

class Factor extends Model
{

    use SoftDeletes;

//    pay caash
    const TYPE_CASH = 1;
    const TYPE_debtor = 2;
    const TYPE_pos = 3;

    const STATUS_PAID = 2;
    const STATUS_UNPAID = 1;


    protected $fillable = [
        'factor_id', 'order_id', 'type', 'transport', 'collecting', 'service', 'status', 'description'
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

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case Factor::STATUS_UNPAID:
                $data['title'] = 'تسویه نشده';
                $data['color'] = 'danger';
                return $data;
                break;
            case Factor::STATUS_PAID:
                $data['title'] = 'تسویه شده';
                $data['color'] = 'success';
                return $data;
                break;
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return Jalalian::forge($value)->format('H:i Y/m/d');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function factorProducts()
    {
        return $this->hasMany(FactorProduct::class);
    }

    public function debtors()
    {
        return $this->hasMany(Debtor::class);
    }

    public function ChangeFactors()
    {
        return $this->hasMany(ChangeFactor::class);
    }
}
