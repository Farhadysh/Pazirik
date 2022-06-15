<?php

namespace App\Http\Controllers\Admin;

use App\Mark;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = new Order();
        $orders = $order->whereHas('mark', function ($q) {
            $q->whereIn('status', [1, 2]);
        })->whereIn('status', [3, 4, 5])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $orders_count = $order->whereHas('mark', function ($q) {
            $q->whereIn('status', [1, 2]);
        })->whereIn('status', [3, 4, 5])
            ->count();

        return view('admin.orders.mark')->with([
            'orders' => $orders,
            'orders_count' => $orders_count
        ]);
    }

    public function update_des(Request $request)
    {
        $id = $request->mark_id;

        Mark::where('id', $id)->update([
            'status' => 2,
            'description' => $request->description
        ]);

        alert()->success('با موفقیت ثبت شد');

        return redirect()->back();
    }

    public function mark_filter(Request $request)
    {
        $order = new Order();
        $orders = $order->whereHas('mark', function ($q) use ($request) {
            $q->where('status', $request->mark_filter);
        })->whereIn('status', [3, 4, 5])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $orders_count = $order->whereHas('mark', function ($q) use ($request) {
            $q->where('status', $request->mark_filter);
        })->whereIn('status', [3, 4, 5])
            ->count();

        return view('admin.orders.mark')->with([
            'orders' => $orders,
            'orders_count' => $orders_count
        ]);
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
     * @param  \App\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function show(Mark $mark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function edit(Mark $mark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark)
    {
        //
    }
}
