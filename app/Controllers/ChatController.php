<?php

namespace App\Controllers;
use App\Models\Users;

class ChatController extends BaseController {
    public function __construct() {
        $this->user = new Users();
    }

    public function Chat() {
        $users = $this->user->getAllUsers();
        $data['page'] = 'chat';
        $data['data'] = ['users' => $users];
        echo view('template', $data);
    }
}