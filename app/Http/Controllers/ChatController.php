<?php

namespace App\Http\Controllers;

use App\Chat;


use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redis;


class ChatController extends Controller
{
    public function getAllMessage(){
        $msgs=Chat::all();
        return response()->json(['messages'=>$msgs]);
    }
    public function postSendMessage(Request $request){
        $message=$request['message'];
        $user_id=Auth::User()->id;

        $chat=new Chat();
        $chat->user_id=$user_id;
        $chat->message=$message;
        $chat->save();

        $msg=Chat::where('id', $chat->id)->first();

        $redis=Redis::connection();
        $redis->publish('message', $msg);

        return response()->json(['messages'=>$msg]);
    }

}
