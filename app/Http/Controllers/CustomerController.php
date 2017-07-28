<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticate');
    }
    public function index(Request $request) {
        $data = [];
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $rooms = $this->getRooms($customer->id);
            $sentMessages = $this->getSentMessages($customer->id);
            $element = array($customer, $rooms, $sentMessages);
            $data[] = $element;
        }

//        foreach ($data as $d) {
//            echo $d[0]->id . PHP_EOL;
//        }
        return view('customer.customer')->with('data', $data);
    }

    public function add(Request $request) {
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');

        $customer = new Customer();
        $customer->name = $name;
        $customer->email = $email;
        $customer->phone = $phone;

        $customer->save();

        $message = "Add new admin successfully";
        $typeMessage = "success";
        $notification = [
            'message' => $message,
            'alert-type' => $typeMessage,
            'title'=>'Notification'
        ];

        return redirect('/customers')->with('notification', $notification);
    }

    public function edit(Request $request) {

        $id = $request->query('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');

        $customer = Customer::where('id', $id)->first();

        if ($customer !== NULL) {
            $customer->name = $name;
            $customer->email = $email;
            $customer->phone = $phone;

            $customer->save();
        }

        $message = "Update admin successfully";
        $typeMessage = "success";

        $notification = [
            'message' => $message,
            'alert-type' => $typeMessage,
            'title'=>'Notification'
        ];
        return redirect('/customers')->with('notification', $notification);
    }


    public function getRooms($id){
        $numberOfRooms = DB::table('messages')->select(DB::raw('count(room_id) as Total'))
            ->where('sender_id', $id)
            ->groupBy('room_id')
            ->get();

        $res = sizeof($numberOfRooms);
        return $res;
    }

    public function getSentMessages($id){
        $numberOfMessages = Message::where('sender_id', $id)
                            ->count();
        return $numberOfMessages;
    }
}
