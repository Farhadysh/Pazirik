<?php

namespace App\Http\Controllers\Admin;

use App\SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SoapClient;

class SMSController extends Controller
{
    public function fluttering()
    {
        return view('admin.SMSPanel.fluttering');
    }

    public function edit()
    {
        $smses = new SMS();
        $smses = $smses->get();

        return view('admin.SMSPanel.edit')->with([
            'smses' => $smses
        ]);
    }

    public function status($id, $status)
    {
        SMS::where('status',$id)->update([
            'active' => $status
        ]);
    }
}
