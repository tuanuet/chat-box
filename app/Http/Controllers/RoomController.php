<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', '<>', 3)
                    ->orderBy('status', 'asc')
                    ->get();
        foreach($rooms as $room)
        {
            $customerName = DB::table('customers')
                ->join('messages', 'customers.id', '=', 'messages.sender_id')
                ->where('messages.room_id', '=', $room->id)
                ->select('customers.name')
                ->get();
            return $customerName;
        }


        return view('room.room')->with('rooms', $rooms);
    }
}
