<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Factor;
use App\Http\Controllers\AdminController;
use App\Mark;
use App\Order;
use App\SMS;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class OrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $order = new Order();
        $orders = $order->whereIn('status', [3, 4, 5])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $orders_count = $order->whereIn('status', [3, 4, 5])->count();

        return view(\request()->route()->getName())->with([
            'orders' => $orders,
            'drivers' => $drivers,
            'orders_count' => $orders_count
        ]);
    }

    public function search(Request $request)
    {
        session([
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'address_index' => $request->address_index,
            'date' => $request->date,
            'driver_id' => $request->driver_id,
            'status' => $request->status,
        ]);

        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->get();

        $orders = new Order();
        $orders = $orders->whereIn('status', [3, 4, 5]);

        if ($request->last_name) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('last_name', 'LIKE', '%' . $request->last_name . '%');
        });
        if ($request->mobile) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('mobile', $request->mobile);
        });
        if ($request->phone) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('phone', $request->phone);
        });
        if ($request->address_index) $orders = $orders->whereHas('address', function ($q) use ($request) {
            $q->where('address_index', 'LIKE', '%' . $request->address_index . '%');
        });
        if ($request->date) $orders = $orders->where('created_at', $request->date);
        if ($request->driver_id) $orders = $orders->where('driver_id', $request->driver_id);

        if ($request->status) $orders = $orders->where('status', $request->status);

        $orders_count = $orders->whereIn('status', [3, 4, 5])->count();

        $orders = $orders->paginate(10);

        return view('admin.orders.index')->with([
            'orders' => $orders->appends(Input::except('page')),
            'drivers' => $drivers,
            'orders_count' => $orders_count
        ]);
    }

    public function orderExcel()
    {
        $order = new Order();
        $orders = $order->whereIn('status', [3, 4, 5])
            ->orderBy('created_at', 'DESC');

        if (session('last_name')) $orders = $orders->whereHas('user', function ($q) {
            $q->where('last_name', 'LIKE', '%' . session('last_name') . '%');
        });
        if (session('mobile')) $orders = $orders->whereHas('user', function ($q) {
            $q->where('mobile', session('mobile'));
        });
        if (session('phone')) $orders = $orders->whereHas('user', function ($q) {
            $q->where('phone', session('phone'));
        });
        if (session('address_index')) $orders = $orders->whereHas('address', function ($q) {
            $q->where('address_index', 'LIKE', '%' . session('address_index') . '%');
        });
        if (session('date')) $orders = $orders->where('created_at', session('date'));
        if (session('driver_id')) $orders = $orders->where('driver_id', session('driver_id'));

        if (session('status')) $orders = $orders->where('status', session('status'));

        $orders = $orders->get();

        $orderExcel[] = array([
            'کد سفارش', 'نام راننده', 'نام مشتری', 'دفتر', 'شیفت', 'توضیحات',
            'تاریخ ثبت سفارش', 'وضعیت سفارش',
        ]);

        foreach ($orders as $order) {
            $orderExcel[] = array([
                'کد سفارش' => $order->id,
                'نام راننده' => $order->driver->name . ' - ' . $order->driver->last_name,
                'نام مشتری' => $order->user->name . ' - ' . $order->user->last_name,
                'دفتر' => $order->office->office_name,
                'شیفت' => $order->shift->from . ' تا ' . $order->shift->to,
                'توضیحات' => $order->description,
                'تاریخ ثبت سفارش' => $order->date,
                'وضعیت سفارش' => $order->status['title'],
            ]);
        }

        session()->forget([
            'last_name', 'mobile', 'phone', 'address_index',
            'date', 'driver_id', 'status'
        ]);

        $export = new OrderExport($orderExcel);
        return Excel::download($export, 'orders.xlsx');
    }


    public function Delivery_To_Factory(Order $order)
    {
        $active = new SMS();
        $active = $active->where('status', 4)->first();

        $mobile = $order->user->mobile;
        $pattern = '104';
        $data = 'به کارخانه تحویل داده شد';

        $order->update([
            'status' => 4
        ]);

        $order->ChangeStatuses()->create([
            'date' => now(),
            'status' => 4,
            'user_id' => auth()->user()->id
        ]);

        if ($active->active == 1) {
            $this->send($mobile, $pattern, $data);
        }

        alert()->success('تحویل داده شد');
        return redirect()->back();
    }

    public function Delivery_To_customer(Order $order)
    {
        return view('admin.factors.Delivered_to_customer')->with([
            'order' => $order
        ]);
    }

    public function Delivered_To_customer(Request $request, Order $order)
    {
        $active = new SMS();
        $active = $active->where('status', 5)->first();

        if ($request->type == 2) {
            $status = 1;
        } else {
            $status = 2;
        }

        $order->factor()->update([
            'status' => $status,
            'type' => $request->type,
            'discount' => $request->discount
        ]);

        $order->update([
            'status' => 5
        ]);
        $order->ChangeStatuses()->create([
            'date' => now(),
            'status' => 5,
            'user_id' => auth()->user()->id
        ]);

        $mobile = $order->user->mobile;
        $pattern = '104';
        $data = 'به شما تحویل داده شد';
        if ($active->active == 1) {
            $this->send($mobile, $pattern, $data);
        }

        alert()->success('با موفقیت انجام شد');
        return redirect()->route('admin.factors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view(\request()->route()->getName())->with([
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view(\request()->route()->getName())->with([
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->address()->update([
            'receive_address' => $request->input('receive_address')
        ]);

        $order->update([
            'status' => $request->input('status')
        ]);


        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.orders.index'));
    }

    public function mark($id, $active)
    {
        if (Mark::where('order_id', $id)->first()) {
            Mark::where('order_id', $id)->update([
                'status' => $active
            ]);
        } else {
            Mark::create([
                'order_id' => $id,
                'status' => $active
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
        } catch (\Exception $e) {
        }
        alert()->success('با موفقیت حذف شد.');
        return redirect()->back();
    }

}
