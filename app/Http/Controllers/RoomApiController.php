<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Message;
use App\Topic;
use Illuminate\Http\Request;
use App\Room;
use function PHPSTORM_META\type;

class RoomApiController extends Controller
{
    public function getAllRooms(Request $request)
    {
        if (!$request->input('id')) {
            return null;
        }
        $result = [];
        // get all in-active room
        $inActiveRooms = Room::where('status', 1)->get();

        // get active of current admin
        $activeRooms = Room::where('status', 2)
            ->where('assignee', $request->input('id'))
            ->get();

        foreach ($inActiveRooms as $inActiveRoom)
        {
            $id = $inActiveRoom->id;  //id
            $firstMessage = Message::where('room_id', $id)
                ->orderBy('created_at')
                ->first();
            if (!$firstMessage) {
                continue;
            }

            $customerId = $firstMessage->sender_id;
            $customerName = Customer::find($customerId)->name;  //customer name

            $topicName = Topic::find($inActiveRoom->topic_id)->name;  //topic name
            $result[] = [
                "id" => $id,
                "topicName" => $topicName,
                "customerName" => $customerName,
                "createdAt" => $inActiveRoom->created_at,
                "status" => $inActiveRoom->status
            ];
        }

        foreach ($activeRooms as $activeRoom)
        {
            $id = $activeRoom->id;  //id
            $firstMessage = Message::where('room_id', $id)
                ->orderBy('created_at')
                ->first();
            if (!$firstMessage) {
                continue;
            }

            $customerId = $firstMessage->sender_id;
            $customerName = Customer::find($customerId)->name;  //customer name

            $topicName = Topic::find($activeRoom->topic_id)->name;  //topic name
            $result[] = [
                "id" => $id,
                "topicName" => $topicName,
                "customerName" => $customerName,
                "createdAt" => $activeRoom->created_at,
                "status" => $activeRoom->status
            ];
        }

        return $result;

    }

}