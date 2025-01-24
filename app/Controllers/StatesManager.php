<?php

namespace App\Controllers;

class StatesManager extends BaseController {
    public function index() {
        $state = [
            'agent' => 'Agent States',
        ];
        $data['page'] = 'states';
        $data['data'] = $state;
        echo view('template', $data);
    }
    public function states($state) {
        // echo $state;
        $url = "http://localhost:3000/redis/create/".$state;
        $currentState = time();
        
        $data = [
            $state => date("s",time())
        ];

        print_r(json_encode($data));

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // $response = curl_exec($ch);
        // // echo $response;
        // return redirect()->to(base_url('/StatesManager/index'));
        // print_r($response);
        // $data['page'] = 'states';
        // $data['data'] = "Hello";
        // echo view('template', $data);
    }
}