<?php

namespace App\Controllers;

class ChatController extends BaseController
{
    public function Chat() {
        $username = session('name');
        $data['page'] = 'chat';
        $data['data'] = ['username' => $username];
        echo view('template', $data);
    }
}