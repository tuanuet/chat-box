<?php
namespace App\Http\Controllers;
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
class UserController extends Controller
{
    private $customer;
    public function __construct(Customer $customer){
        $this->customer = $customer;
    }

    public function createToken(Request $request)
    {

//        $customer = $this->customer->create([
//            'name' => $request->get('name'),
//            'email' => $request->get('email'),
//            'password' => bcrypt($request->get('password'))
//        ]);

        /** get customer data
         * json request must be have full of field include: "name", "email", "phone", "topicId", "message"*/
        $credentials = $request->json()->all();
        //authenticate json from client
        if ($credentials == null ) {
            $credentials = $request->only('name', 'email', 'phone', 'topicId', 'message');
        }

        $name = $credentials['name'];
        $phone = $credentials['phone'];
        $email = $credentials['email'];
        $msg = $credentials['message'];
        $topicId = $credentials['topicId'];

        /** validate data*/
        if(!$name || !$phone || !$email || !$msg || !$topicId) {
            return response()->json(['error' => 'invalid input'], 422);
        }

        /** add new customer to db*/
        $customer = new Customer;
        $customer->name = $name;
        $customer->phone = $phone;
        $customer->email = $email;

        /** create a new room */
        $room = new Room;
        $room->topic_id = $topicId;
        $room->status = 0;
        $room->assignee = 0;
        $room->created_at = Carbon::now();


        if ($customer->save() && $room->save()) {

            /** create first message of customer*/
            $message = new Message;
            $message->room_id = $room->id;
            $message->sender_id = $customer->id;
            $message->content = $msg;
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
            return response()->json(compact('token'));
        }
        else response()->json(['failed_to_create_token_db'], 500);


    }
    public function getAuthUser(Request $request){

        $data = JWTAuth::getPayload($request->input('token'));

        return response()->json(['customerId' => $data['sub'],
            'customerName' => $data['customerName'],
            'customerEmail' => $data['customerEmail'],
            'customerPhone' => $data['customerPhone'],
            'roomId' => $data['roomId']]);
    }

}