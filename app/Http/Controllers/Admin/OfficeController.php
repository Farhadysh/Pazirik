<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offices = new Office();
        $offices = $offices->get();
        return view(\request()->route()->getName())->with([
            'offices' => $offices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = new User();
        $users = $users->where('level', 'admin')->where('active', 1)->get();

        return view(\request()->route()->getName())->with([
            'users' => $users
        ]);
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
            'office_name' => 'required',
            'phone' => 'required|numeric',
            'user' => 'required',
            'address' => 'required',
            'type_office' => 'required'
        ]);

        $office = new Office();
        $office->office_name = $request->office_name;
        $office->user_id = $request->user;
        $office->status = $request->type_office;
        $office->user_id = $request->user;
        $office->phone = $request->phone;
        $office->address = $request->address;
        $office->save();

        alert()->success('با موفقیت ثبت شد');

        return redirect()->route('admin.offices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Office $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Office $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        $users = new User();
        $users = $users->where('level', 'admin')->where('active', 1)->get();

        return view('admin.offices.edit')->with([
            'users' => $users,
            'office' => $office
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Office $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        $request->validate([
            'office_name' => 'required',
            'phone' => 'required|numeric',
            'user' => 'required',
            'address' => 'required',
            'type_office' => 'required',
        ]);

        $office->office_name = $request->office_name;
        $office->user_id = $request->user;
        $office->status = $request->type_office;
        $office->phone = $request->phone;
        $office->address = $request->address;
        $office->save();

        alert()->success('با موفقیت ویرایش شد');

        return redirect()->route('admin.offices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Office $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        try {
            $office->delete();
        } catch (\Exception $e) {
        }
        alert()->success('با موفقیت حذف شد!');
        return redirect(route('admin.offices.index'));
    }
}
