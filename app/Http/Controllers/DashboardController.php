<?php

namespace App\Http\Controllers;

use App\Room;
use App\Room_Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    function __construct()
    {
        $this->middleware('authenticate');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getDashboard(Request $request)
    {

//        $rooms = Room_Account::
//        select( 'rooms.name as roomName','rooms.id as roomId',
//            'rooms.created_at',
//            DB::raw('count(*) as accounts, rooms.id'))->
//
//        join('accounts','rooms_accounts.account_id','=','accounts.id')->
//        join('rooms','rooms.id','=','rooms_accounts.room_id')->
//        groupBy('rooms.id')->
//        orderBy('accounts','desc')->
//        limit(10)->
//        get();

        $rooms = Room::all();

        $countRoom = DB::table('rooms')->count();

        $countAccount = DB::table('customers')-> count();

        return view('dashboard.index',['rooms'=>$rooms,'countRoom'=>$countRoom,'countAccount'=>$countAccount]);
    }
}