<?php

namespace App\Http\Controllers\API\v1;

use App\Order;
use App\Http\Resources\Order as OrderResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function driverOrders($id)
    {
        $orders = new Order();
        $orders = $orders->where('driver_id', $id)->where('status', 2)->with(['user', 'address', 'shift'])->orderBy('date', 'desc')->get();

        return OrderResource::collection($orders);
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|integer',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'data' => [
                    'message' => $validator->errors(),
                    'status' => 'error'
                ]
            ], 422);
        }

        $order = Order::find($request->id);

        if ($order) {

            $order->status = $request->status;
            $order->save();

            $order->ChangeStatuses()->create([
                'date' => Jalalian::now(),
                'status' => $request->status,
                'user_id' => $order->driver_id
            ]);

            return response([
                'data' => [
                    'message' => 'با موفقیت تحویل کارخانه گردید.',
                    'status' => 200
                ]
            ], 200);

        } else {
            return response([
                'data' => [
                    'message' => 'سفارش یافت نشد.',
                    'status' => 422
                ]
            ], 422);
        }
    }
}
