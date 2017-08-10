<?php

namespace App\Http\Controllers;

use App\Room;
use App\Room_Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    function __construct()
    {
        $this->middleware('jwt.authAdmin');
    }

    public function getDashboard(Request $request)
    {
        $rooms = Room::all();

        $countRoom = DB::table('rooms')->count();

        $countAccount = DB::table('customers')-> count();

        return view('dashboard.index',['rooms'=>$rooms,'countRoom'=>$countRoom,'countAccount'=>$countAccount]);
    }


}
