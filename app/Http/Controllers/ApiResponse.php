<?php

/**
 * Created by PhpStorm.
 * User: MRC2
 * Date: 18-Feb-16
 * Time: 5:03 PM
 */

namespace App\Http\Controllers;
class ApiResponse
{
    private $params = array();
    private $shareText = "";

    public function showError($error)
    {
        $this->success = false;
        $this->error = $error;
        $this->data = null;
        return $this->printData();
    }

    public function showData($data, $config = 0)
    {
        $this->success = true;
        $this->error = null;
        $this->data = $data;

        if ($config == 0)
            return $this->printData();
        else if ($config == 1)
            return $this->printConfigData();
    }

    public function show($data,$error)
    {
        $this->success = true;
        $this->error = $error;
        $this->data = $data;

        return $this->printData();
    }

    public function addParams($params)
    {
        $this->params = $params;
    }

    public function printData()
    {
        $response = array("success" => $this->success, "data" => $this->data, "error" => $this->error);
        $response = array_merge($response, $this->params);

        return $response;
    }

    public function printConfigData()
    {
        $response = array("success" => $this->success, "data" => $this->data, "error" => $this->error, "min_ver" => 2, "cur_ver" => 2, "share_text" => $this->shareText);
        $response = array_merge($response, $this->params);
        return $response;
    }

    public function showVCConfig()
    {
        $this->data = array('cur_ver' => 3, 'url' => '');
        return array_merge($this->data, array("error" => null));
    }
}