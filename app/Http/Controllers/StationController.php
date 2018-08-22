<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use Validator;
use App\User;
use DB;
class StationController extends Controller
{
    public function getData($id){
    	$response = new ApiResponse();
    	try{
    		$station = Station::findOrFail($id)->get();
    		if(count($station)>0){
    			return $response->showData($station[0]);
    		}
    		else{
    			return $response->showError('Station details Not Found');
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
    		'name'=>'required|string',
    		'address'=>'required|string',
    		'type'=>'required|integer',
    		'latitude'=>['required','regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$'],
    		'longtitude'=>['required','regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$'],
    		'station_id'=>'required',
    	]);
    	$response = new ApiResponse;
		if ($validator->fails()) {
            $arr = $validator->errors()->getMessages();
            $keys = array_keys($arr);
            return $response->showError($arr[$keys[0]][0]);
        }
        else{
			try{
			$station = new Station;
			$station->name = $request->name;
			$station->address = $request->address;
			$station->id = $request->station_id;
			$station->latitude = $request->latitude;
			$station->longtitude = $request->longtitude;
			$station->type = $request->type;
			$station->user_id = $request->user_id;

			$station->save();
			return $response->showData($station);
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
