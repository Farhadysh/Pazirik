<?php

namespace App\Http\Controllers\Admin;

use App\Cheque;
use App\Debtor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DebtorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->merge([
            'cost' => str_replace(',', '', $request->input('cost')),
        ]);

        $request->validate([
            'cost' => 'required|integer',
            'date' => 'required'
        ]);

        if ($request->final_price >= $request->cost) {
            if ($request->cheque_date) {
                $cheque = new Cheque();
                $cheque->price = str_replace(',','',$request->input('cost'));
                $cheque->date = $request->input('cheque_date');
                $cheque->cheque_number = $request->input('cheque_number');
                $cheque->save();

                $cheque->debtor()->create([
                    'cost' => str_replace(',', '', $request->input('cost')),
                    'date' => $request->input('date'),
                    'cheque_id' => $cheque->id,
                    'factor_id' => $request->input('factor_id')
                ]);

                if ($request->final_price == $cheque->debtor->cost) {
                    $cheque->debtor->factor()->update([
                        'status' => 2
                    ]);
                }

                alert()->success('با موفقیت ثبت شد');

                return redirect(route('admin.factors.installmentEdit',
                    ['id' => $request->factor_id]));
            }


            $debtor = new Debtor();
            $debtor->factor_id = $request->input('factor_id');
            $debtor->cost = str_replace(',', '', $request->input('cost'));
            $debtor->date = $request->input('date');
            $debtor->save();

            if ($request->final_price == $debtor->cost) {
                $debtor->factor()->update([
                    'status' => 2
                ]);
            }

            alert()->success('با موفقیت ثبت شد');

            return redirect(route('admin.factors.installmentEdit',
                ['id' => $request->factor_id]));
        } else {
            alert()->error('مبلغ بیش از حد مجاز است!');

            return redirect(route('admin.factors.installmentEdit',
                ['id' => $request->factor_id]));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Debtor $debtor
     * @return \Illuminate\Http\Response
     */
    public function show(Debtor $debtor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Debtor $debtor
     * @return \Illuminate\Http\Response
     */
    public function edit(Debtor $debtor)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Debtor $debtor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Debtor $debtor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Debtor $debtor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Debtor $debtor)
    {
        $factor_id = $debtor->factor->id;

        try {
            $debtor->delete();
            alert()->success('با موفقیت حذف شد!');
            return redirect(route('admin.factors.installmentEdit',
                ['id' => $factor_id]));
        } catch (\Exception $e) {
        }
    }
}
