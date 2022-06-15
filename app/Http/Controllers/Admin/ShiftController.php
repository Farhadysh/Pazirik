<?php

namespace App\Http\Controllers\Admin;

use App\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shift = new Shift();
        $shifts = $shift
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $shifts_count = $shift->count();

        return view(\request()->route()->getName())->with([
            'shifts' => $shifts,
            'shifts_count' => $shifts_count
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
        $request->validate([
            'from' => 'required|integer',
            'to' => 'required|integer',
        ]);

        $shift = new Shift();
        $shift->from = $request->input('from');
        $shift->to = $request->input('to');
        $shift->save();

        alert()->success('با موفقیت ثبت شد.');

        return redirect(route('admin.shifts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        return view(\request()->route()->getName())->with([
            'shift' => $shift
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'from' => 'required|integer',
            'to' => 'required|integer',
        ]);

        $shift->from = $request->input('from');
        $shift->to = $request->input('to');
        $shift->active = $request->input('active');
        $shift->save();

        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.shifts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {

    }
}
