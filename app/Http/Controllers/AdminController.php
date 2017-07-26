<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Mockery\Exception;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();
        return view('admin.admin', ['admins'=>$admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');

        #echo $name . " " . $email . " " . $phone . " " . $password;

        $message = "Add new admin successfully";
        $typeMessage = "success";

        if (sizeof(Admin::where('email', $email)->get()) > 0) {
            $message = "Couldn't add new admin! Email is used!";
            $typeMessage = "error";
        } else {
            $admin = new Admin();
            $admin->name = $name;

            $admin->phone = $phone;
            $admin->email = $email;

            $admin->password = bcrypt($password);

            $admin->save();
        }

        $notification = [
            'message' => $message,
            'alert-type' => $typeMessage,
        ];
        return redirect('admin')->with('notification', $notification);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function profile(Request $request)
    {
        $id = $request->query('id');

        $admin = Admin::where('id', $id)->get();

        if (sizeof($admin) !== 0) {
            return dd($admin->first());
        } else {
            echo "WRONG!";
        }
    }
}
