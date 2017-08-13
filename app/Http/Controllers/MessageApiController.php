<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Message;
use Illuminate\Http\Request;

class MessageApiController extends Controller
{
    public function getMessages(Request $request)
    {
        $messages = Message::where('room_id', $request->roomid)
            ->orderBy('created_at')
            ->get();
        $result = [];

        foreach($messages as $message)
        {
            $senderName = null;
            if($message->sender_id == 0) {
                $senderName = "Admin";
            } else {
                $senderName = Customer::find($message->sender_id)->name;
            }

            $result[] = [
                "id" => $message->id,
                "senderId" => $message->sender_id,
                "senderName" => $senderName,
                "message" => ["content" => $message->content,
                                "type" => $message->message_type],
                "metaLink" => false,
                "time" => $message->created_at
            ];
        }
        return $result;
    }
}
