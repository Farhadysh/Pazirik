<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $settings = new Setting();
        $settings = $settings->get();

        return view(\request()->route()->getName())->with([
            'settings' => $settings
        ]);
    }

    public function update(Request $request, $id)
    {

        $setting = new Setting();
        $setting = $setting->where('id',$id)->first();

        $setting->value = $request->description;
        $setting->save();

        alert()->success('با موفقیت ویرایش شد');
        return redirect()->back();
    }
}
