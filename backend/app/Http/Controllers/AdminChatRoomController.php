<?php

namespace App\Http\Controllers;

use App\Events\AdminChatEvent;
use App\Events\ChatEvent;
use App\Models\Models\ChatRoom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminChatRoomController extends Controller
{

    public function index(){
        $cm_total=[];
        $cm_user= ChatRoom::select('chat_rooms.user_id',)
            ->distinct('chat_rooms.user_id')->where('chat_rooms.user_id', '!=', null)->get()->pluck('user_id');
       $customer_msgs= $cm_user;

        $cm = array();
        if(count($customer_msgs)>0){
            foreach($customer_msgs as $cm_id )
            {
                $cm[] = ChatRoom::select(
                    'chat_rooms.id',
                    'chat_rooms.chat_room_id',
                    'chat_rooms.user_id',
                    'chat_rooms.message',
                    'chat_rooms.created_at',
                    'users.name as user_name',
                    'model_has_roles.role_id',
                    'roles.name as role_name',
                )
                    ->leftjoin('users','users.id','chat_rooms.user_id')
                    ->leftjoin('model_has_roles','model_has_roles.model_id','chat_rooms.user_id')
                    ->leftjoin('roles','roles.id','model_has_roles.role_id')
                    ->where('chat_rooms.user_id',$cm_id)
                    ->orderByDesc('chat_rooms.id')
                    ->first();
//                array_push($cm_total,$cm);

            }
        }
//        return $cm;
//        $itemCollection = $this->r_collect( $cm_total);
//        $cm_total= $itemCollection->pagianate(5);

        return response()->json(['customer_info'=>$cm]);
//        return response()->json(
//         [
//                'customer_msg'=>$customer_msg,
//                'customer_info'=>$cm_total]
//            );

    }
    function r_collect($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = r_collect($value);
                $array[$key] = $value;
            }
        }

        return collect($array);
    }
    public function live_chat( Request $request){
        if($request->messages){
            $chat_room = new ChatRoom();
            $chat_room->chat_room_id = $request->customer_id;
            $chat_room->user_id = $request->user_id;
            $chat_room->type = 'admin';
            $chat_room->message = $request->messages;
            $chat_room->save();
            event(new AdminChatEvent($chat_room->message));
            return response()->json(['success']);
        }
        else{
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

    }
    public function previous_msg($id){
//        $prv_msgs= ChatRoom::select('message','created_at')->where('user_id',$request->user_id)->where('chat_room_id',$request->customer_id)->get();
//        $all_msg=[];
//        foreach ($prv_msgs as $pv){
//            if($pv->message){
//                array_push($all_msg,['message'=>$pv['message'] ,'time'=>$pv['created_at'] ]);
////                array_push($all_msg,$pv->message,);
////                array_push($all_msg,$pv->created_at,);
//            }
//        }
//        return response()->json(['all_msg'=>$all_msg]);
        $all_msg = ChatRoom::select('message', 'user_id','type', 'created_at')->where('chat_room_id',$id)->get();
        return response()->json(['all_msg'=>$all_msg]);
    }
    public function receive_msg( Request $request){
        $rcv_msgs= ChatRoom::select('message','created_at')->where('user_id',$request->customer_id)->where('chat_room_id',$request->customer_id)->get();
        $all_msg=[];
        foreach ($rcv_msgs as $pv){
            if($pv->message){
                array_push($all_msg,['message'=>$pv['message'] ,'time'=>$pv['created_at'] ]);
               // array_push($all_msg,$pv->created_at);
            }
        }
        return response()->json(['all_rcv_msg'=>$all_msg]);
    }
}
