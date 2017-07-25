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
}
