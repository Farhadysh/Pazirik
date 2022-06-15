<?php

namespace App\Http\Controllers\Admin;

use App\Cost;
use App\Exports\CostExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cost = new Cost();
        $costs = $cost
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $costs_count = $cost->count();

        return view(\request()->route()->getName())->with([
            'costs' => $costs,
            'costs_count' => $costs_count
        ]);
    }

    public function costExcel()
    {
        $cost = new Cost();
        $costs = $cost->orderBy('created_at', 'DESC')->get();

        $costExcel[] = array([
            'نام', 'تعداد', 'فی', 'مبلغ هزینه', 'تاریخ', 'توضیحات'
        ]);

        foreach ($costs as $cost) {
            $costExcel[] = array([
                'نام' => $cost->name,
                'تعداد' => $cost->count,
                'فی' => $cost->price,
                'مبلغ هزینه' => $cost->price * $cost->count,
                'تاریخ' => $cost->date,
                'توضیحات' => $cost->description
            ]);
        }

        $export = new CostExport($costExcel);
        return Excel::download($export, 'orders.xlsx');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(\request()->route()->getName());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'price' => str_replace(',', '', $request->input('price'))
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'count' => 'required|string',
            'price' => 'required|integer',
            'date' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $cost = new Cost();
        $cost->name = $request->input('name');
        $cost->count = $request->input('count');
        $cost->price = str_replace(',', '', $request->price);
        $cost->date = $request->input('date');
        $cost->description = $request->input('description');
        $cost->save();

        alert()->success('با موفقیت ثبت شد.');

        return redirect(route('admin.costs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cost $cost
     * @return \Illuminate\Http\Response
     */
    public function show(Cost $cost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cost $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Cost $cost)
    {
        return view(\request()->route()->getName())->with([
            'cost' => $cost
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Cost $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cost $cost)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'count' => 'required|string',
            'price' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $cost->name = $request->input('name');
        $cost->count = $request->input('count');
        $cost->price = $request->input('price');
        $cost->date = $request->input('date');
        $cost->description = $request->input('description');
        $cost->save();

        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.costs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cost $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cost $cost)
    {
        try {
            $cost->delete();
        } catch (\Exception $e) {
        }
        alert()->success('با موفقیت حذف شد!');
        return redirect(route('admin.costs.index'));
    }
}
