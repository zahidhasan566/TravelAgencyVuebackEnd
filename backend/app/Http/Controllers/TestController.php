<?php

namespace App\Http\Controllers;

use App\Models\Models\ChatRoom;
use Illuminate\Http\Request;

class TestController extends Controller
{

        public function receive_msg(){

            return ChatRoom::select('message', 'user_id', 'created_at')->where('chat_room_id',38)->get();

//            $customer_msgs= ChatRoom::select('message','created_at')->where('user_id',38)->where('chat_room_id',38)->get();
//            $all_customer_msg=[];
//            foreach ($customer_msgs as $pv){
//                if($pv->message){
//                    array_push($all_customer_msg,['message'=>$pv['message'] ,'time'=>$pv['created_at'] ]);
//                    // array_push($all_msg,$pv->created_at);
//                }
//            }
//            foreach ($all_customer_msg as $cm){
//                $cm_ms= $cm['time'];
//                $cm_str =$cm['message'];
//                $all_admim_msg=[];
//                $admin_msgs= ChatRoom::select('message','created_at')->where('user_id',34)->where('chat_room_id',38)->get();
//                foreach ($admin_msgs as $pv){
//                    if($pv->message){
//                        array_push($all_admim_msg,['message'=>$pv['message'] ,'time'=>$pv['created_at'] ]);
//                        // array_push($all_msg,$pv->created_at);
//                    }
//                }
//                foreach ($all_admim_msg as $am){
//                    $am_ms= $am['time'];
//                    $am_str= $am['message'];
//                    if($cm_ms>$am_ms){
//                        echo  $cm_ms.$cm_str.'<br>';
//                    }
//                    else{
//                        echo  $am_ms.$am_str.'<br>';
//                    }
//
//                }
//            }


        }

}
