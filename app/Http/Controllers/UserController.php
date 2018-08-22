<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
	public function getData($id){
		$response= new ApiResponse();
		try{
			$user = User::select('name','email','role','google_id')->where('google_id',$id)->get();
			// $user = User::select('*')->where('google_id',$id)->get();
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

	public function addData(Request $request){
		
		$validator = Validator::make($request->all(),[
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
			$user->google_id = $request->google_id;
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
