<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
class CustomerController extends Controller
{
    public function index(Request $request) {
        $customers = Customer::all();
        return view('customer.customer')->with('customers', $customers);
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

        return redirect('/customers');
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

        return redirect('/customers');
    }
}
