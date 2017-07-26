<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use App\Room;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', '<>', 3)->get();
        $room_array = [];
        foreach($rooms as $room)
        {

            $customerName = DB::table('customers')
                ->join('messages', 'customers.id', '=', 'messages.sender_id')
                ->where('messages.room_id', '=', $room->id)
                ->select('customers.name')
                ->first()->name;
            if($room->status === 1 || $room->assignee === 1)  //assume 1 is admin's id
            $room_array[] = ['id' => $room->id,
                    'customerName' => $customerName,
                    'topic' => Topic::find($room->topic_id)->name,
                    'status' => $room->status,
                    'created_at' => $room->created_at
            ];
        }

        return view('room.room', ['rooms' => $room_array]);
    }

}
