<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Admin;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.authAdmin');
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
            $message = "Could not add new admin! Email is used!";
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
            'title'=>'Notification'
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
//            return dd($admin->first());
            return view('admin.profile', ['admin'=>$admin->first()]);
        } else {
            echo "WRONG!";
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        $id = $request->query('id');

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');

        $admins = Admin::where('id', $id)->get();

        $message = "Update profile successfully";
        $typeMessage = "success";

        if (sizeof($admins) !== 0) {
//          return dd($admin->first());
            $admin = $admins->first();
            $oldEmail = $admin->email;
            if (sizeof(Admin::where('email', $email)->get()) > 0 && $email != $oldEmail) {
                $message = "Could not update profile! Email is used!";
                $typeMessage = "error";
            } else {
                $admin->name = $name;

                $admin->phone = $phone;
                $admin->email = $email;

                $admin->password = bcrypt($password);

                $admin->save();
            }
            $url = '/admin/profile?id=' . $id;
            $notification = [
                'message' => $message,
                'alert-type' => $typeMessage,
                'title'=>'Notification'
            ];
            return redirect($url)->with('notification', $notification);
        } else {
            echo "WRONG!";
        }
    }
}
