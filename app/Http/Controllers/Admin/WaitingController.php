<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\ChangeStatus;
use App\Http\Controllers\AdminController;
use App\Order;
use App\Shift;
use App\SMS;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class WaitingController extends AdminController
{
    public function index()
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $shifts = new Shift();
        $shifts = $shifts->where('active', 1)->get();

        $order = new Order();
        $orders = $order->whereIn('status', [1, 2])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $orders_count = $order->whereIn('status', [1, 2])->count();

        return view(\request()->route()->getName())->with([
            'orders' => $orders,
            'drivers' => $drivers,
            'shifts' => $shifts,
            'orders_count' => $orders_count
        ]);
    }

    public function search(Request $request)
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $shifts = new Shift();
        $shifts = $shifts->where('active', 1)->get();

        $orders = new Order();
        $orders = $orders->whereIn('status', [1, 2]);

        if ($request->last_name) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('last_name', 'LIKE', '%' . $request->last_name . '%');
        });
        if ($request->mobile) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('mobile', $request->mobile);
        });
        if ($request->address_index) $orders = $orders->whereHas('address', function ($q) use ($request) {
            $q->where('address_index', 'LIKE', '%' . $request->address_index . '%');
        });
        if ($request->date) $orders = $orders->where('created_at', $request->date);
        if ($request->driver_id) $orders = $orders->where('driver_id', $request->driver_id);
        if ($request->shift_id) $orders = $orders->where('shift_id', $request->shift_id);

        $orders_count = $orders->whereIn('status', [1, 2])->count();

        $orders = $orders->paginate(10);

        return view('admin.waits.index')->with([
            'orders' => $orders->appends(Input::except('page')),
            'drivers' => $drivers,
            'shifts' => $shifts,
            'orders_count' => $orders_count
        ]);
    }

    public function transport_all(Request $request)
    {

        $orders = new Order();
        $orders = $orders->where('status', 1);

        if ($request->date) $orders = $orders->where('created_at', $request->date);
        if ($request->driver_id) $orders = $orders->where('driver_id', $request->driver_id);
        if ($request->shift_id) $orders = $orders->where('shift_id', $request->shift_id);

        $orders->update([
            'status' => 2
        ]);

        alert()->success('با موفقیت انتقال یافت');

        return redirect()->back();

    }

    public function Transmitted(Request $request)
    {
        $active = new SMS();
        $active = $active->where('status', 2)->first();

        $orders = new Order();
        $orders = $orders->whereIn('id', $request->check);
        $orders->update([
            'status' => 2
        ]);

        $sms_to = $orders->whereIn('id', $request->check)->first();
        $mobile = $sms_to->user->mobile;
        $pattern = '104';
        $data = 'راننده ارسال شد';
        if ($active->active == 1) {
            $this->send($mobile, $pattern, $data);
        }

        $orders = $orders->get();
        foreach ($orders as $order) {
            $order->ChangeStatuses()->create([
                'date' => now(),
                'status' => 2
            ]);
        }

    }

    public function notTransmitted(Request $request)
    {
        $orders = new Order();
        $orders = $orders->whereIn('id', $request->check);
        $orders->update([
            'status' => 1
        ]);
        $orders = $orders->get();
        foreach ($orders as $order) {
            $order->ChangeStatuses()->create([
                'date' => now(),
                'status' => 1
            ]);
        }

    }

    public function edit(Order $order)
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $shifts = new Shift();
        $shifts = $shifts->where('active', 1)->get();

        return view(\request()->route()->getName())->with([
            'order' => $order,
            'drivers' => $drivers,
            'shifts' => $shifts
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'mobile' => 'required',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required',
            'driver_id' => 'required',
            'shift_id' => 'required',
            'date' => 'required',
        ]);

        $user = new User();
        $user->where('id', $order->user_id)
            ->update([
                'name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'mobile' => $request->input('mobile'),
                'phone' => $request->input('phone'),
            ]);


        if (($request->input('address_id'))) {
            $order->update([
                'address_id' => $request->input('address_id')
            ]);

        } else if ($request->input('address')) {
            $request->validate([
                'address' => 'required|string|max:255',
                'address_index' => 'required|string|max:255'
            ]);

            $address = new Address();
            $address->where('id', $request->input('adr_id'))
                ->update([
                    'address' => $request->input('address'),
                    'address_index' => $request->input('address_index'),
                    'description' => $request->input('description_adr'),
                ]);
        } else {
            $request->validate([
                'address' => 'required|string|max:255'
            ]);
        }

        $order->driver_id = $request->input('driver_id');
        $order->date = $request->input('date');
        $order->shift_id = $request->input('shift_id');
        $order->description = $request->input('description');
        $order->status = 1;
        $order->save();


        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.waits.index'));

    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
        } catch (\Exception $e) {
        }
        alert()->success('با موفقیت حذف شد!');
        return redirect(route('admin.waits.index'));
    }
}
