<?php

namespace App\Http\Controllers\API\v1;

use App\ChangeFactor;
use App\ChangeStatus;
use App\Factor;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FactorController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->all() as $factors) {

            $validator = Validator::make($factors, [
                'factor_id' => 'required',
                'order_id' => 'required',
                'date' => 'required',
                'transport' => 'required',
                'discount' => 'required',
                'service' => 'required',
                'collecting' => 'required',
                'type' => 'required',
                'status' => 'required',
                'factorProducts.*' => 'required'
            ]);

            if ($validator->fails()) {
                return response([
                    'data' => [
                        'message' => $validator->errors(),
                        'status' => 'error'
                    ]
                ], 422);
            }

            $factor = Factor::where('factor_id', $factors["factor_id"])->first();

            $order = Order::where('id', $factors["order_id"])->first();

            $order->status = $factors['order']['status'];
            $order->save();

            if ($factor) {

                if ($factors['updated'] == 1) {
                    if (!ChangeFactor::where('factor_id', $factors["factor_id"])->exists()) {
                        $change = ChangeFactor::create([
                            'factor_id' => $factor->factor_id,
                            'order_id' => $factor->order_id,
                            'date' => $factor->date,
                            'transport' => $factor->transport,
                            'service' => $factor->service,
                            'collecting' => $factor->collecting,
                            'discount' => $factor->discount,
                            'status' => $factor->status,
                            'type' => $factor->getOriginal('type'),
                        ]);

                        foreach ($factor->factorProducts as $p) {
                            $change->changeFactorProducts()->create([
                                'count' => $p->count,
                                'defection' => $p->defection,
                                'price' => $p->price,
                                'product_id' => $p->product_id,
                            ]);
                        }
                    }
                }


                if ($factors["done"]) {
                    ChangeStatus::create([
                        'order_id' => $factors["order_id"],
                        'date' => $factors['done'],
                        'status' => $factors['order']['status'],
                        'user_id' => $order->driver_id,
                    ]);
                }

                $factor->collecting = $factors["collecting"];
                $factor->service = $factors["service"];
                $factor->transport = $factors["transport"];
                $factor->discount = $factors["discount"];
                $factor->date = $factors["date"];
                $factor->status = $factors["status"];
                $factor->type = $factors["type"];
                $factor->save();

                $factor->factorProducts()->delete();
                foreach ($factors["factorProducts"] as $factorProduct) {
                    $factor->factorProducts()->create([
                        'count' => $factorProduct["count"],
                        'defection' => $factorProduct["defection"],
                        'price' => $factorProduct["price"],
                        'product_id' => $factorProduct["product_id"],
                    ]);
                }

            } else {

                ChangeStatus::create([
                    'order_id' => $factors["order_id"],
                    'date' => $factors['date'],
                    'status' => $factors['order']['status'],
                    'user_id' => $order->driver_id,
                ]);

                $factor = Factor::create([
                    'factor_id' => $factors["factor_id"],
                    'order_id' => $factors["order_id"],
                    'collecting' => $factors["collecting"],
                    'service' => $factors["service"],
                    'transport' => $factors["transport"],
                    'discount' => $factors["discount"],
                    'date' => $factors["date"],
                    'status' => $factors["status"],
                    'type' => $factors["type"],
                ]);

                foreach ($factors["factorProducts"] as $factorProduct) {
                    $factor->factorProducts()->create([
                        'factor_id' => $factors["factor_id"],
                        'product_id' => $factorProduct["product_id"],
                        'count' => $factorProduct["count"],
                        'defection' => $factorProduct["defection"],
                        'price' => $factorProduct["price"],
                    ]);
                }
            }
        }

        return response([
            'data' => [
                'message' => 'با موفقیت ارسال شد.',
                'status' => 'success'
            ]
        ], 200);
    }
}
