<?php

namespace App\Http\Controllers;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Customer;
use App\Room;
use App\Message;
use JWTAuthException;
use Carbon\Carbon;
use Config;
use Mockery\Exception;

class UserController extends Controller
{
    private $customer;
    public function __construct(Customer $customer){
        $this->customer = $customer;
    }

    public function createToken(Request $request)
    {

        /** get customer data
         * json request must be have full of field include: "name", "email", "phone", "topicId", "message"*/
        $credentials = $request->json()->all();
        if ($credentials == null ) {
            $credentials = $request->only('name', 'email', 'phone', 'topicId', 'message');
        }

        $name = $credentials['name'];
        $phone = $credentials['phone'];
        $email = $credentials['email'];
        $msg = $credentials['message'];
        $topicId = $credentials['topicId'];

        /** validate data*/
        if(!$name || !$topicId) {
            return response()->json(['error' => 'invalid input'], 422);
        }

        /** add new customer to db*/
        $customer = new Customer;
        $customer->name = $name;
        $customer->phone = ($phone? $phone : "");
        $customer->email = ($email? $email : "");

        /** create a new room */
        $room = new Room;
        $room->topic_id = $topicId;
        $room->created_at = Carbon::now();


        if ($customer->save() && $room->save()) {

            /** create first message of customer*/
            $message = new Message;
            $message->room_id = $room->id;
            $message->sender_id = $customer->id;
            $message->content = ($msg? $msg : "");
            $message->created_at = Carbon::now();

            if (!$message->save()) {
                return response()->json(['failed_to_create_token_caused_message_save'], 422);
            }


            /**create token by 5 fields: customerId, customerName, customerEmail, customerPhone and roomId */
            $token = null;

            try {
                Config::set('auth.providers.customers.model', Customer::class);
                if (!$token = JWTAuth::fromUser($customer,[
                    "customerName" => $customer->name,
                    "customerPhone" => $customer->phone,
                    "customerEmail" => $customer->email,
                    "roomId" => $room->id,
                ])) {
                    return response()->json(['failed_to_create_token'], 500);
                }
            } catch (JWTAuthException $e) {
                return response()->json(['failed_to_create_token_error'], 500);
            }
            return response()->json(["token" => $token, "customer" => $customer, 'room' => $room]);
        }
        else response()->json(['failed_to_create_token_db'], 500);


    }
    public function getAuthUser(Request $request){
        $data = JWTAuth::getPayload($request->input('token'));
        $roomId = $data['roomId'];
        $messages = Message::where('room_id', $roomId)->get();

        $admin = null;
        $room = null;
        try{
            $room = Room::find($roomId);
            $admin = Admin::find($room->assignee);

        }catch (Exception $e) {
            return $e;
        }

        return response()->json(['customer' => ['customerId' => $data['sub'],
            'customerName' => $data['customerName'],
            'customerEmail' => $data['customerEmail'],
            'customerPhone' => $data['customerPhone']
            ],
            'room' => $room,
            'messages' => $messages,
            'admin' => $admin]);
    }

}