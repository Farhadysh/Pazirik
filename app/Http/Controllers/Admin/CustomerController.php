<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\ChangeStatus;
use App\Exports\UsersExport;
use App\Http\Controllers\AdminController;
use App\Order;
use App\Shift;
use App\SMS;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class CustomerController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new User();
        $users = $user->where('level', 'user')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $users_count = $user->where('level', 'user')->count();

        return view(\request()->route()->getName())->with([
            'users' => $users,
            'users_count' => $users_count
        ]);
    }

    public function search(Request $request)
    {
        $users = new User();
        $users = $users->where('level', 'user');

        if ($request->last_name) $users = $users->where('last_name', 'LIKE', "%{$request->last_name}%");
        if ($request->mobile) $users = $users->where('mobile', $request->mobile);
        if ($request->phone) $users = $users->where('phone', $request->phone);

        $users_count = $users->where('level', 'user')->count();
        $users = $users->paginate(10);

        return view('admin.customers.index')->with([
            'users' => $users,
            'users_count' => $users_count
        ]);
    }

    public function mobile_search($mobile)
    {
        $users = new User();
        $users = $users->where('mobile', $mobile)->first();

        $user_addresses = $users->addresses;

        if ($users == null) {
            return false;
        } else {
            return with([
                'user' => $users,
                'addresses' => $user_addresses
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $shifts = new Shift();
        $shifts = $shifts->where('active', 1)->get();

        return view(\request()->route()->getName())->with([
            'drivers' => $drivers,
            'shifts' => $shifts
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
        $active = new SMS();
        $active = $active->where('status', 1)->first();

        $request->validate([
            'mobile' => 'required|numeric',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required',
            'driver_id' => 'required',
            'shift_id' => 'required',
            'date' => 'required'
        ]);
        if ($request->input('user_id')) {

            $user = User::find($request->user_id);

            if ($request->input('address')) {
                $request->validate([
                    'address' => 'required|string|max:255',
                    'address_index' => 'required|string|max:255'
                ]);
                $address = $user->addresses()->create([
                    'user_id' => $request->input('user_id'),
                    'address' => $request->input('address'),
                    'address_index' => $request->input('address_index'),
                ]);
            } else if ($request->input('address_id')) {
                $address = Address::find($request->input('address_id'));

                $mobile = $user->mobile;
                $pattern = '104';
                $data = 'آدرس شما با موفقیت ثبت شد';
                if ($active->active == 1) {
                    $this->send($mobile, $pattern, $data);
                }

            } else {
                $request->validate([
                    'address' => 'required|string|max:255'
                ]);
            }

            $order = new Order();
            $order->driver_id = $request->input('driver_id');
            $order->user_id = $request->input('user_id');
            $order->address_id = $address->id;
            $order->shift_id = $request->input('shift_id');
            $order->date = $request->input('date');
            $order->description = $request->input('description_adr');
            $order->save();

            $order->ChangeStatuses()->create([
                'user_id' => auth()->user()->id,
                'date' => now(),
                'status' => 1
            ]);

            $mobile = $user->mobile;
            $pattern = '104';
            $data = 'آدرس شما با موفقیت ثبت شد';
            if ($active->active == 1) {
                $this->send($mobile, $pattern, $data);
            }

            alert()->success('با موفقیت ثبت شد.');

            return redirect(route('admin.customers.create'));

        } else {
            DB::beginTransaction();

            $request->validate([
                'address' => 'required|string|max:255',
                'address_index' => 'required|string|max:255'
            ]);

            try {
                $user = new User();
                $user->name = $request->input('name');
                $user->last_name = $request->input('last_name');
                $user->mobile = $request->input('mobile');
                $user->phone = $request->input('phone');
                $user->save();

                $address = $user->addresses()->create([
                    'address' => $request->address,
                    'address_index' => $request->input('address_index'),
                ]);
                $order_status = $user->orders()->create([
                    'driver_id' => $request->input('driver_id'),
                    'address_id' => $address->id,
                    'shift_id' => $request->input('shift_id'),
                    'date' => $request->input('date'),
                    'description' => $request->input('description_adr')
                ]);

                ChangeStatus::create([
                    'user_id' => auth()->user()->id,
                    'order_id' => $order_status->id,
                    'date' => now(),
                    'status' => 1
                ]);

                DB::commit();

                $mobile = $user->mobile;
                $pattern = '104';
                $data = 'آدرس شما با موفقیت ثبت شد';
                if ($active->active == 1) {
                    $this->send($mobile, $pattern, $data);
                }

                alert()->success('با موفقیت ثبت شد.');

                return redirect(route('admin.customers.create'));

                // all good
            } catch (\Exception $e) {
                DB::rollback();
                alert()->error('این کاربر قبلا ثبت شده است');
                return redirect()->back();
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $orders = $user->orders()->with('factor')->paginate(5);
        return view(\request()->route()->getName())->with([
            'user' => $user,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view(\request()->route()->getName())->with([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string',
            'mobile' => 'required|numeric|max:11',
            'phone' => 'required|string'
        ]);

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->mobile = $request->input('mobile');
        $user->phone = $request->input('phone');
        $user->save();

        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.customers.index'));
    }

    public function excel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
    }

}
