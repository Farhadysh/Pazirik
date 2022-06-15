<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new User();
        $users = $user->whereIn('level', ['admin', 'driver'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $users_count = $user->whereIn('level', ['admin', 'driver'])->count();

        return view(\request()->route()->getName())->with([
            'users' => $users,
            'users_count' => $users_count
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = new Role();
        $roles = $roles->get();

        return view(\request()->route()->getName())->with([
            'roles' => $roles
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
            'name' => 'required|string',
            'last_name' => 'required|string',
            'mobile' => 'required|numeric',
            'phone' => 'required|numeric',
            'national_code' => 'required|numeric',
            'level' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->input('user_id')) {

            $user = User::find($request->user_id);

            $user->name = $request->input('name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->password = Hash::make($request->input('password'));
            $user->mobile = $request->input('mobile');
            $user->phone = $request->input('phone');
            $user->national_code = $request->input('national_code');
            $user->level = $request->input('level');
            $user->car_number = $request->input('car_number');
            $user->save();

            $user->roles()->sync($request->role);

            alert()->success('با موفقیت ثبت شد.');

            return redirect(route('admin.users.index'));
        } else {
            DB::beginTransaction();
            try {
                $user = new User();
                $user->name = $request->input('name');
                $user->last_name = $request->input('last_name');
                $user->username = $request->input('username');
                $user->password = Hash::make($request->input('password'));
                $user->mobile = $request->input('mobile');
                $user->phone = $request->input('phone');
                $user->national_code = $request->input('national_code');
                $user->level = $request->input('level');
                $user->car_number = $request->input('car_number');
                $user->save();

                $user->roles()->sync($request->role);

                DB::commit();
                alert()->success('با موفقیت ثبت شد.');

                return redirect(route('admin.users.index'));

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = new Role();
        $roles = $roles->get();

        return view(\request()->route()->getName())->with([
            'user' => $user,
            'roles' => $roles
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
            'name' => 'required|string',
            'last_name' => 'required|string',
            'mobile' => 'required',
            'phone' => 'required',
            'national_code' => 'required',
            'level' => 'required',
            'username' => 'required'
        ]);

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->mobile = $request->input('mobile');
        $user->phone = $request->input('phone');
        $user->username = $request->input('username');
        $user->national_code = $request->input('national_code');
        $user->level = $request->input('level');
        $user->car_number = $request->input('car_number');
        $user->save();

        $user->roles()->sync($request->role);

        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.users.index'));
    }

    public function check_active($id, $active)
    {
        $user = new User();
        $user = $user->where('id', $id);

        $user->update([
            'active' => $active
        ]);
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required',
            'config_password' => 'required|same:password'
        ]);

        $user->password = Hash::make($request->input('password'));
        $user->save();

        alert()->success('کلمه عبور با موفقیت تغییر یافت');
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
