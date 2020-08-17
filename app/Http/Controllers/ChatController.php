<?php

namespace App\Http\Controllers;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use App\User;
class ChatController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }
   public function chat()
   {
     return view('chat');
   }
   public function send(Request $request)
   {
     $user=User::findOrFail(auth()->id());
     event(new ChatEvent($request->message,$user));
     $this->saveToSession($request);
     return $request->message;
   }
   public function saveToSession($request=null)
   {
     if($request!==null){
       session()->put('chat',$request->chat);
    }else{
       session()->put('chat',request('chat'));
    }
   }
   public function clearFromSession()
   {
      session()->forget('chat');
   }
   public function getOldMessages()
   {
     return session('chat');
   }
}
