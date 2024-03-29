<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use Validator;
use App\User;
use DB;
class StationController extends Controller
{
    public function getStation($id){
    	$response = new ApiResponse();
    	try{
    		$station = Station::where('id',$id)->get();
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

    public function addStation(Request $request){
    	$validator = Validator::make($request->all(),[
    		'name'=>'required|string',
    		'user_id'=>'required|string|exists:users,user_id',
    		'address'=>'required|string',
    		'type'=>'required|integer',
    		'latitude'=>'required','regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$',
    		'longitude'=>'required','regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$',
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
			$station->latitude = $request->latitude;
			$station->longitude = $request->longitude;
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


    public function getNearestStations(Request $request){
        $validator = Validator::make($request->all(),[
            'radius'=> 'required',
            'latitude'=>'required','regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$',
            'longitude'=>'required','regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$',
        ]);
        $response = new ApiResponse();
        if ($validator->fails()) {
            $arr = $validator->errors()->getMessages();
            $keys = array_keys($arr);
            return $response->showError($arr[$keys[0]][0]);
        }
        else{
            try{
                $lat = request('latitude');
                $lng = request('longitude');
                $radius = request('radius');
                $station = DB::table('stations')
                ->select('id','name','address','latitude','longitude',DB::raw('('.$radius.' * acos (cos ( radians('.$lat.') )* cos(radians( latitude ) )* cos( radians( longitude ) - radians('.$lng.') )+ sin ( radians('.$lat.') )* sin( radians( latitude ) ) )) as distance'))
                ->having('distance','<','20')
                ->orderBy('distance')
                ->take('10')
                ->get();
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

    public function searchStation($name,Request $request){
        $response = new ApiResponse();
        try{
            $station = Station::select('*')
                    ->where('name','LIKE',$name.'%')
                    ->get();
            if(count($station)>0){
            return $response->showData($station);
            }
            else{
                return $response->showError('Details not found');
            }        
        }
        catch(Exception $e){
        $error_log = new ErrorLog();
        $error_log->message = $e->getMessage();
        $error_log->save();
        return $response->showError("Data access error : " . $e->getMessage());   
        }
    }
}
