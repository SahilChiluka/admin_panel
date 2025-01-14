<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Report extends BaseController {
    public function index() {
        $curl = curl_init();
        $url = 'http://localhost:3000/mysql/get/overallReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        $data['page'] = 'overallReport';
        $data['data'] = ['calls' => $response];
        echo view('template',$data);
    }

    public function hourly() {
        $curl = curl_init();
        $url = 'http://localhost:3000/mysql/get/hourlyReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        $data['page'] = 'hourlyReport';
        $data['data'] = ['hourlyCalls' => $response];
        echo view('template',$data);
    }
}
