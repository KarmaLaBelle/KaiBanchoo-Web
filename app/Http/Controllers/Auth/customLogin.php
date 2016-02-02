<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use URL;

class customLogin extends Controller
{
    protected $redirectTo = '/home';

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $credentials = ['email' => $request->input('email'), 'password' => md5($request->input('password'))];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect()->intended($this->redirectTo);
        } else {
            return redirect()->back()->withErrors(['password' => 'The password is incorrect']);
        }
    }
}
