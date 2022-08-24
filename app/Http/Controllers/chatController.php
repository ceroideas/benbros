<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Auth;
// use LRedis;
 
class chatController extends Controller {

	public function sendMessage(Request $r){

		$m = new Message;
		$m->from = $r->from;
		$m->to = $r->to;
		$m->message = $r->message;
		if ($r->to == null) {
			$m->seen = [(string)Auth::id()];
		}
		$m->save();
	}

	public function loadMessages($id = null)
	{
		if ($id == null) {
			$messages = Message::where('to',null)->get();
		}else{
			$messages = Message::where(function($q) use($id){
				$q->where(function($q) use($id){
					$q->where('from',Auth::user()->id)
					  ->where('to',$id);
				})->orwhere(function($q) use($id){
					$q->where('to',Auth::user()->id)
					  ->where('from',$id);
				});
			})->where('to','!=',null)->with('fromUser','toUser')->take(10)->get();
		}

		return view('messages', compact('messages'));

	}

	public function setSeen(Request $r)
	{
		$m = Message::where('from',$r->from)->where('to',$r->to)->get();

		if ($r->from == null) {
			$m = Message::where('from',Auth::id())->where('to',null)->get();
		}

		foreach ($m as $key => $value) {
			$seen = $value->seen;
			$seen[] = (string)$r->to;
			$value->seen = array_unique($seen);
			$value->save();
		}
	}
}