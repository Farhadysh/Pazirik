<?php

namespace App\Http\Controllers\Admin;

use App\ChangeFactor;
use App\ChangeOrder;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ChangeFactorController extends Controller
{
    public function index()
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->get();

        $factor = new ChangeFactor();
        $factor_count = $factor->count();
        $factors = $factor->with('changeOrder')->paginate(10);

        return view(\request()->route()->getName())->with([
            'factors' => $factors,
            'drivers' => $drivers,
            'factor_count' => $factor_count
        ]);
    }

    public function show(ChangeFactor $factor)
    {
        $total = 0;

        foreach ($factor->changeFactorProducts as $p) {
            $total += $p->count * $p->price;
        }

        $total += $factor->transport + $factor->collecting + $factor->service - $factor->discount;

        $factor->changeOrder()->update([
            'seen' => 1
        ]);

        return view(\request()->route()->getName())->with([
            'factor' => $factor,
            'total' => $total
        ]);
    }

    public function search(Request $request)
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->get();

        $factor = new ChangeFactor();
        $factor = $factor->with('changeOrder');

        if ($request->last_name) $factor = $factor->whereHas('changeOrder.user', function ($q) use ($request) {
            $q->where('last_name', 'LIKE', '%' . $request->last_name . '%');
        });
        if ($request->mobile) $factor = $factor->whereHas('changeOrder.user', function ($q) use ($request) {
            $q->where('mobile', $request->mobile);
        });
        if ($request->address_index) $factor = $factor->whereHas('changeOrder.address', function ($q) use ($request) {
            $q->where('address_index', 'LIKE', '%' . $request->address_index . '%');
        });

        if ($request->driver_id) $factor = $factor->whereHas('changeOrder.driver', function ($q) use ($request) {
            $q->where('driver_id', $request->driver_id);
        });

        if ($request->date) $factor = $factor->whereHas('changeOrder', function ($q) use ($request) {
            $q->where('created_at', $request->date);
        });

        $factor_count = $factor->count();

        $factor = $factor->paginate(10);

        return view('admin.changes.index')->with([
            'factors' => $factor->appends(Input::except('page')),
            'drivers' => $drivers,
            'factor_count' => $factor_count
        ]);
    }

}
