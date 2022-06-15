<?php

namespace App\Http\Controllers\API\v1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
       if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user()->only(['id','name','last_name','mobile']);
//            $success['token'] = $user->createToken('AppName')->accessToken;
            return response()->json([
                'data' => [
                    'status' => 200,
                    'user' => $user
                ]
            ]);
        } else {
            return response()->json(['data' => [
                'status' => 401,
            ]]);
        }
    }
}
