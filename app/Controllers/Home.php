<?php

namespace App\Controllers;

use App\Models\Users;
use App\Models\Accesslevels;

class Home extends BaseController {
    protected $model;
    protected $access;

    public function __construct() {
        $this->model = new Users();
        $this->access = new Accesslevels();
    }

    public function index() {
        $home = [
            'admin' => 'Admin Dashboard',
        ];
        $data['page'] = 'admin';
        $data['data'] = $home;
        echo view('template', $data);
    }

    public function userpage() {
        $filterRole = $this->request->getGet('filterRole') ?? null;
        $filterName = $this->request->getGet('searchName') ?? null;
        $filterEmail = $this->request->getGet('searchEmail') ?? null;

        $userdata = $this->model->getFilteredUsers($filterRole, $filterName, $filterEmail);
        $accessdata = $this->access->getAccessLevels();

        $data['page'] = 'users';
        $data['data'] = ['users' => $userdata, 'accessname' => $accessdata];
        $data['filteraccess'] = $accessdata;
        $data['pager'] = $this->model->pager;

        echo view('template', $data);
    }

    public function createuserpage() {
        $accessdata = $this->access->getAccessLevels();
        $data['page'] = 'createuser';
        $data['data'] = ['accesslevels' => $accessdata];
        echo view('template', $data);
    }

    public function adduser() {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirmpassword');
        $role = $this->request->getPost('role');

        if ($this->model->isUsernameExists($username)) {
            session()->setFlashData('username', 'Username already exists');
            return redirect()->to(base_url('Home/createuserpage'));
        }

        if ($this->model->isEmailExists($email)) {
            session()->setFlashData('email', 'Email already exists');
            return redirect()->to(base_url('Home/createuserpage'));
        }

        if ($password !== $confirm_password) {
            session()->setFlashData('password', 'Password and Confirm Password do not match');
            return redirect()->to(base_url('Home/createuserpage'));
        }

        $this->model->createUser ($username, $email, $password, $role);
        return redirect()->to(base_url('Home/userpage'));
    }

    public function editpage($id) {
        $user = $this->model->getUserById($id);
        $accesslevels = $this->access->getAccessLevels();

        $data['page'] = 'edituser';
        $data['data'] = ['user' => $user, 'accesslevels' => $accesslevels];
        echo view('template', $data);
    }

    public function updateuser($id) {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $role = $this->request->getPost('role');

        $this->model->updateUser ($id, $username, $email, $role);
        return redirect()->to(base_url('Home/userpage'));
    }

    public function delete($id) {
        $this->model->deleteUser($id);
        return redirect()->to(base_url('Home/userpage'));
    }

    public function login() {
        return view('login');
    }

    public function loginuser() {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->model->getUserByEmail($email);

        if (!$user) {
            session()->setFlashData('error', 'Invalid email');
            return redirect()->to('/login');
        }

        if ($password !== $user['password']) {
            session()->setFlashData('error', 'Invalid password');
            return redirect()->to('/login');
        }

        $session = session();
        $session->set([
            'id' => $user['user_id'],
            'name' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);

        return redirect()->to(base_url('/'));
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}