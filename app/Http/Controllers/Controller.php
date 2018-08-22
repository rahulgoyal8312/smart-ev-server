<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test_data(Request $request)
    {
        $response= new ApiResponse();
        return $response->showData("Hello world!");
    }

    public function test_error(Request $request)
    {
        $response= new ApiResponse();
        return $response->showError("Some error occured!");
    }
}
