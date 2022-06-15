<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_Not_Transmitted = 1;
    const STATUS_Transmitted = 2;
    const STATUS_Delivery_From_Customer = 3;
    const STATUS_Delivery_To_Factory = 4;
    const STATUS_Delivery_To_Customer = 5;

    protected $fillable = [
        'user_id', 'driver_id', 'address_id', 'done', 'status', 'shift_id', 'description', 'date'
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
        return Jalalian::forge($value)->format('H:i    Y/m/d');
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

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function factor()
    {
        return $this->hasOne(Factor::class);
    }

    public function ChangeStatuses()
    {
        return $this->hasMany(ChangeStatus::class);
    }

    public function mark()
    {
        return $this->hasOne(Mark::class);
    }

    public function changeFactor()
    {
        return $this->hasOne(ChangeFactor::class);
    }

}
