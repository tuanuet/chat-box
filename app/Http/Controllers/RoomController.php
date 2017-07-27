<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Message;
use App\Topic;
use Illuminate\Http\Request;
use App\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

class RoomController extends Controller
{


    public function __construct()
    {
        $this->middleware('authenticate');
    }

    public function index()
    {

        $rooms = Room::where('status', '<>', 3)
                        ->get();
        $room_array = [];
        foreach($rooms as $room) {

            $customerName = DB::table('customers')
                ->join('messages', 'customers.id', '=', 'messages.sender_id')
                ->where('messages.room_id', '=', $room->id)
                ->orderBy('messages.created_at')
                ->select('customers.name')
                ->first();
            if(!$customerName) {
                $room->delete();
                continue;
            }
            if (($room->status === 1 && $room->assignee === 0)|| $room->assignee === Auth::user()->id) {

                $room_array[] = ['id' => $room->id,
                    'customerName' => $customerName->name,
                    'topic' => Topic::find($room->topic_id)->name,
                    'status' => $room->status,
                    'created_at' => $room->created_at
                ];
            }
        }


//        $notification = array(
//            'message' => 'Welcome to Room',
//            'title' => 'Welcome',
//            'alert-type' => 'warning'
//        );
//        \Session::put('message', $notification['message']);
//        \Session::put('title', $notification['title']);
//        \Session::put('alert-type', $notification['alert-type']);

        return view('room.room', ['rooms' => $room_array]);
    }


    public function history()
    {
        $rooms = Room::where('status', 3)
                        ->where('assignee', Auth::user()->id)->get();
        $room_array = [];
        foreach($rooms as $room) {

            $customerName = DB::table('customers')
                ->join('messages', 'customers.id', '=', 'messages.sender_id')
                ->where('messages.room_id', '=', $room->id)
                ->orderBy('messages.created_at')
                ->select('customers.name')
                ->first();
            if(!$customerName) {
                $room->delete();
                continue;
            }

                $room_array[] = ['id' => $room->id,
                    'customerName' => $customerName->name,
                    'topic' => Topic::find($room->topic_id)->name,
                    'status' => $room->status,
                    'created_at' => $room->created_at
                ];

        }

        return view('room.history', ['rooms' => $room_array]);
    }

    public function showChatLog($room_id)
    {
        $admin_id = Room::find($room_id)->assignee;
        if(!$admin_id) {
            return "Can't find assignee of room";
        }

        $room_messages = Message::where('room_id', $room_id)->orderBy('created_at')->get();
        $customer_id = $room_messages[0]->sender_id;
        $messages = [];
        foreach ($room_messages as $message)
        {
            $sender_name = '';
            if($message->sender_id != 0) {
                $sender_name = Customer::find($message->sender_id)->name;
            }

            $messages[] = [
                'sender_id' => $message->sender_id,
                'sender_name' => $sender_name,
                'content' => $message->content,
                'sent_time' => $message->created_at
            ];
        }
//        dd(Room::find($room_id)->status);
        $customer = Customer::find($customer_id);
        return view('room.chatlog', ['messages' => $messages,
            'room' => Room::find($room_id),
            'room_type' => Topic::find(Room::find($room_id)->topic_id)->name,
            'customer' => $customer
        ]);
    }

    public function chat($room_id)
    {
        $room = Room::find($room_id);
//        dd(Auth::user()->id);
        if($room->assignee != 0 && $room->assignee != Auth::user()->id) {
            $notification = [
                'message' => 'Room has been assigned by other one!',
                'alert-type' => 'warning',
                'title' => 'Error'
            ];

            return redirect('/room')->with('notification', $notification);
        }
//        dd(Auth::user()->id);
        if($room->assignne == 0) {
            $room->assignee = Auth::user()->id;
            $room->status = 2;
            $room->save();
        }

        $room_messages = Message::where('room_id', $room_id)->orderBy('created_at')->get();
        $messages = [];
        foreach ($room_messages as $message)
        {
            $sender_name = '';
            if($message->sender_id != 0) {
                $sender_name = Customer::find($message->sender_id)->name;
            }

            $messages[] = [
                'sender_id' => $message->sender_id,
                'sender_name' => $sender_name,
                'content' => $message->content,
                'sent_time' => $message->created_at
            ];
        }
        return view('chat.chat', ['messages' => $messages,
            'room' => $room,
            'room_type' => Topic::find($room->topic_id)->name
        ]);
    }

}
