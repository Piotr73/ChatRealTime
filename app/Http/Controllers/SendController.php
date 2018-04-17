<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Input;
use DB;

class SendController extends Controller
{
    public function postCreate(Request $request){

		 	/*$validator = Validator::make(Input::all(), Message::rules(),[],Message::niceNames());

		 	$validator = Validator::make(Input::all(), [
            'name' => 'required|unique:posts|max:255',
            'body' => 'required',
        	]);*/

		 	$arr['name'] = $request->get('name');
			$arr['email'] = $request->get('email');
			$arr['subject'] = $request->get('subject');
			$arr['message'] = $request->get('message');

			/*var_dump($arr['name']);*/

		    /*if ($validator->fails()) {
				
				$error = $validator->errors();
				$arr['success'] = false;
				$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .implode('', $error->all(':message<br />')). '</div>';
				
				
		    } else {*/
		    	$msg = new Message($request->all());
            	$msg->save();
				$id = DB::getPdo()->lastInsertId();  
				$arr = Message::DetailMessage($id);				
		    	$arr['new_count_message'] = count(Message::CountNewMessage());
				$arr['success'] = true;
				$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Message sent ...</div>';

		    /*}*/

		    return response()->json(['success'=>$arr['success'],'id'=>$arr['id'],'name'=>$arr['name'],'email'=>$arr['email'],'subject'=>$arr['subject'],'seen'=>$arr['seen'],'message'=>$arr['message'],'created_at'=>$arr['created_at'],'updated_at'=>$arr['updated_at'],'new_count_message'=>$arr['new_count_message'],'notif'=>$arr['notif']]);
	
	}
}
