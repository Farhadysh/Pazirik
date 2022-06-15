<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class ChangeStatus extends Model
{

    const STATUS_Not_Transmitted = 1;
    const STATUS_Transmitted = 2;
    const STATUS_Delivery_From_Customer = 3;
    const STATUS_Delivery_To_Factory = 4;
    const STATUS_Delivery_To_Customer = 5;

    protected $fillable = [
        'order_id','user_id','date', 'status'
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

    public function getDateAttribute($value)
    {
        return Jalalian::forge($value)->format('H:i  Y/m/d');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
