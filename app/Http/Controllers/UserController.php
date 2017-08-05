<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use App\Customer;
use App\Room;
use App\Message;
use JWTAuthException;
use Carbon\Carbon;
class UserController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }

    public function createToken(Request $request)
    {
//        $user = $this->user->create([
//            'name' => $request->get('name'),
//            'email' => $request->get('email'),
//            'password' => bcrypt($request->get('password'))
//        ]);

        /** get user data
         * json request must be have full of field include: "name", "email", "phone", "topicId", "message"*/
        $credentials = $request->json()->all();
        //authenticate json from client
        if (!$credentials || !$credentials['name'] || !$credentials['email'] || !$credentials['phone']
            || !$credentials['topicId']) {
           return response()->json(['Invalid input'],422);
        }

        /** add new customer to db*/
        $user = new Customer;
        $user->name = $credentials['name'];
        $user->phone = $credentials['phone'];
        $user->email = $credentials['email'];

        /** create a new room */
        $room = new Room;
        $room->topic_id = $credentials['topicId'];
        $room->status = 0;
        $room->assignee = 0;
        $room->created_at = Carbon::now();



        if ($user->save() && $room->save()) {

            /** create first message of customer*/
            $message = new Message;
            $message->room_id = $room->id;
            $message->sender_id = $user->id;
            $message->content = $credentials['message'];
            $message->created_at = Carbon::now();

            if (!$message->save()) {
                return response()->json(['failed_to_create_token_caused_message_save'], 422);
            }

            /**create token by 5 fields: customerId, customerName, customerEmail, customerPhone and roomId */
            $token = null;
            try {
                if (!$token = JWTAuth::attempt([
                    "customerId" => $user->id,
                    "customerName" => $user->name,
                    "customerPhone" => $user->phone,
                    "customerEmail" => $user->email,
                    "roomId" => $room->id]
                )) {
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
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }
}