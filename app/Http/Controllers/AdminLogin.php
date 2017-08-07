<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Controller
{
    function index(Request $request)
    {
        $token = $request->cookie('token');
//        echo $token;
        if ($token == null) {
//            $client = new Client();
//            $res = $client->request('GET', 'http://local.chat.com/api/getAdminData?token=' . $token);
//            dd($res->getBody());
            return view('login.login-admin');
        } else {
            $client = new Client();
            $res = $client->request('GET','http://local.chat.com/api/getAdminData?token=' . $token)->getBody();
            //do with res
            //dd(\GuzzleHttp\json_decode($res) -> result -> id);
            $id = \GuzzleHttp\json_decode($res) -> result -> id;
            Auth::loginUsingId($id);
            $cookie = cookie('token', $token);
            return redirect('/dashboard')->withCookie($cookie);
        }
    }

    function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $client = new Client();
        try {
            $res = $client->request('POST', 'http://local.chat.com/api/login', [
                'form_params' => [
                    'email' => $email,
                    'password' => $password
                ]
            ])->getBody();
            //dd(\GuzzleHttp\json_decode($res));
            $token = \GuzzleHttp\json_decode($res)->token;
            $cookie = cookie('token', $token);
            return redirect('/dashboard')->withCookie($cookie);
        } catch (RequestException $e) {
            return redirect('login')->with('result', 'fail');
        }
    }

    public function logout()
    {
        $cookie = \Cookie::forget('token');
        Auth::logout();
        //echo "logout";
        return redirect('/')->withCookie($cookie);
    }

}
