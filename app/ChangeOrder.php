<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class ChangeOrder extends Model
{
    const STATUS_Not_Transmitted = 1;
    const STATUS_Transmitted = 2;
    const STATUS_Delivery_From_Customer = 3;
    const STATUS_Delivery_To_Factory = 4;
    const STATUS_Delivery_To_Customer = 5;

    protected $fillable = [
        'old_id','seen','user_id', 'driver_id', 'address_id', 'done', 'status', 'shift_id', 'description', 'date'
    ];

    public function getStatusAttribute($value)
    {
        $data = [];
        switch ($value) {
            case Order::STATUS_Not_Transmitted:
                $data['title'] = 'انتقال داده نشده';
                $data['color'] = 'danger';
                return $data;
                break;
            case Order::STATUS_Transmitted:
                $data['title'] = 'انتقال داده شده';
                $data['color'] = 'success';
                return $data;
                break;
            case Order::STATUS_Delivery_From_Customer:
                $data['title'] = 'دریافت کالا';
                $data['color'] = 'danger';
                return $data;
                break;
            case Order::STATUS_Delivery_To_Factory:
                $data['title'] = 'تحویل به کارخانه';
                $data['color'] = 'warning';
                return $data;
                break;
            case Order::STATUS_Delivery_To_Customer:
                $data['title'] = 'تحویل به مشتری';
                $data['color'] = 'success';
                return $data;
                break;
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return Jalalian::forge($value)->format('H:i  Y/m/d');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function changeAddress()
    {
        return $this->belongsTo(ChangeAddress::class, 'address_id');
    }

    public function changeAddresses()
    {
        return $this->hasMany(ChangeAddress::class);
    }

    public function changeFactor()
    {
        return $this->hasOne(ChangeFactor::class);
    }
}
