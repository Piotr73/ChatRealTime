<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function index(){

		$contents['ListMessage']      = Message::ListMessage();
		$contents['CountNewMessage']  = count(Message::CountNewMessage());

		return view('message',$contents);
	
	}

	public function updateSeen(Request $request){
		$id = $request->get('id');		
		if($id){
			Message::UpdateSeen($id);
			$arr = Message::DetailMessage($id);
			$arr['update_count_message'] = count(Message::CountNewMessage());
			/*return json_encode($arr);*/
			return response()->json(['success'=>'true','id'=>$arr['id'],'name'=>$arr['name'],'email'=>$arr['email'],'subject'=>$arr['subject'],'seen'=>$arr['seen'],'message'=>$arr['message'],'created_at'=>$arr['created_at'],'updated_at'=>$arr['updated_at'],'update_count_message'=>$arr['update_count_message']]);
		}
		
	}
}
