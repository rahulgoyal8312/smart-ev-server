<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
	public function getUser($user_id){
		$response= new ApiResponse();
		try{
			$user = User::where('user_id',$user_id)->get();
			// $user = User::where('google_id',$id)->get();
			if(count($user)>0){
				return $response->showData($user[0]);
			}
			else{
				return $response->showError('User Not Found');
			}
		}
		catch(Exception $e){
			$error_log = new ErrorLog();
            $error_log->message = $e->getMessage();
            $error_log->save();
            return $response->showError("Data access error : " . $e->getMessage());
		}
	}

	public function addUser(Request $request){
		
		$validator = Validator::make($request->all(),[
			'user_id'=> 'required|unique:users,user_id',
			'email'=> 'required|email',
			'name' => 'required|string',
			'role' => 'required',
		]);
		$response = new ApiResponse;
		if ($validator->fails()) {
            $arr = $validator->errors()->getMessages();
            $keys = array_keys($arr);
            return $response->showError($arr[$keys[0]][0]);
        }
        else{
			try{
			// User::create(request(['name','email','role','google_id']));
			$user = new User;
			$user->name = $request->name;
			$user->email = $request->email;
			$user->user_id = $request->user_id;
			$user->role = $request->role;
			$user->save();
			return $response->showData($user);
			} 
			catch(Exception $e){
			$error_log = new ErrorLog();
            $error_log->message = $e->getMessage();
            $error_log->save();
            return $response->showError("Data access error : " . $e->getMessage());
			}	
		}
	}
}
