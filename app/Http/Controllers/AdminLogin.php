<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Controller
{
    function index()
    {
        if (!Auth::check()) {
            return view('login.login-admin');
        } else {
            return redirect('/dashboard');
        }
    }

    function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

//        $data = DB::table('accounts')->select('password')->where('email', $email)->first();
//        if (isset($data) && Hash::check($password, $data->password)) {
//            return redirect()->action('AdminController@showDatabase');
//        } else {
//            return redirect('admin')->with('result', 'fail');
//        }
        //echo $email . " " . $password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
//            echo "success";
            return redirect('/dashboard');
//            return redirect()->intended('dashboard');
//                var_dump(Auth::user());
//                var_dump(Auth::check());
        } else {
            return redirect('login')->with('result', 'fail');
        }

    }

    public function logout()
    {
        Auth::logout();
        //echo "logout";
        return redirect('/');
    }

}
