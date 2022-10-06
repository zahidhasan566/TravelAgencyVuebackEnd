<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Models\ChatRoom;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ChatRoomController extends Controller
{
    public function create_room( Request $request){
        $roles= Db::table('model_has_roles')->select('roles.name')
            ->leftJoin('roles','roles.id','model_has_roles.role_id')
            ->where('model_has_roles.model_id',$request->Id)
            ->get();

       if( $roles[0]->name == 'Customer'){
           $chat_room = new ChatRoom();
           $chat_room->chat_room_id = $request->Id;
           $chat_room->user_id = $request->Id;
           $chat_room->save();
           return response()->json(['success']);
       }
       else{
           throw ValidationException::withMessages([
               'message' => ['The provided credentials are incorrect.'],
           ]);
       }
    }
    public function live_chat( Request $request){
        if($request->messages){
            $chat_room = new ChatRoom();
            $chat_room->chat_room_id = $request->id;
            $chat_room->user_id = $request->id;
            $chat_room->message = $request->messages;
            $chat_room->type = 'customer';
            $chat_room->save();

            event(new ChatEvent($chat_room->message));
            return response()->json(['success']);
        }
        else{
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

    }
    public function previous_msg($id){
//        $prv_msgs= ChatRoom::select('message','created_at')->where('user_id',$id)->get();
//        $all_msg=[];
//        foreach ($prv_msgs as $pv){
//            if($pv->message){
//                array_push($all_msg,['message'=>$pv['message'] ,'time'=>$pv['created_at'] ]);
//            }
//        }
//        return response()->json(['all_msg'=>$all_msg]);
        $all_msg = ChatRoom::select('message', 'user_id','type', 'created_at')->where('chat_room_id',$id)->get();
        return response()->json(['all_msg'=>$all_msg]);
    }
    public function receive_msg( Request $request){
        $rcv_msgs= ChatRoom::select('message','created_at')->where('user_id',$request->admin_id)->where('chat_room_id',$request->id)->get();
        $all_rcv_msg=[];
        foreach ($rcv_msgs as $pv){
            if($pv->message){
                array_push($all_rcv_msg,['message'=>$pv['message'] ,'time'=>$pv['created_at'] ]);
//                array_push($all_msg,$pv->message,);
//                array_push($all_msg,$pv->created_at,);
            }
        }
        return response()->json(['all_rcv_msg'=>$all_rcv_msg]);
    }
}
