<?php

namespace App\Controllers;
use App\Models\Users;
use App\Models\Accesslevels;

class Home extends BaseController
{
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
        $pager = service('pager');

        // $db = \Config\Database::connect();
        // $query = 'select *, ( select access_level from accesslevels where accesslevels.access_id = users.role ) as accessname from users;';
        // $resultTable = $db->query($query);

        $accessdata = $this->access->getAccessLevels();

        $filterRole = $this->request->getGet('filterRole') ?? null;
        $filterName = $this->request->getGet('searchName') ?? null;
        $filterEmail = $this->request->getGet('searchEmail') ?? null;

        $userdata = $this->model->getFilteredUsers($filterRole, $filterName, $filterEmail);

        $data['page'] = 'users';
        $data['data'] = ['users' => $userdata, 'accessname' => $accessdata];
        $data['filteraccess'] = $accessdata;
        $data['pager'] = $this->model->pager;
        
        echo view('template', $data);
    }

    public function createuserpage() { 
        $accessmodel = new Accesslevels();
        $accesslevels = $accessmodel->findAll();
        $data['page'] = 'createuser';
        $data['data'] = ['accesslevels' => $accesslevels];
        echo view('template', $data);
        // return view('header').view('createuser',['accesslevels' => $accesslevels]).view('footer');
    }

    public function adduser() {
                      
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirmpassword');
        $role = $this->request->getPost('role');

        $userameExists = $this->model->where('username',$username)->first();
        $emailExists = $this->model->where('email',$email)->first();
        
        if($userameExists) {
            session()->setFlashData('username', 'Username already exists');
            return redirect()->to('/createuserpage');
        } else if($emailExists) {
            session()->setFlashData('email', 'Email already exists');
            return redirect()->to('/createuserpage');
        }else {
            if($password == $confirm_password) {
                $this->model->save([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role
                ]);
                return redirect()->to('/users');
            } else {
                session()->setFlashData('password', 'Password and Confirm Password does not match');
                return redirect()->to('/createuserpage');
            }
        }
    }

    public function editpage($id) {
        $user = $this->model->where('user_id',$id)->first();
        $accessmodel = new Accesslevels();
        $accesslevels = $accessmodel->findAll();
        // print_r($user);
        $data['page'] = 'edituser';
        $data['data'] = ['user' => $user, 'accesslevels' => $accesslevels];
        echo view('template', $data);
        // return view('header').view('edituser',['user' => $user, 'accesslevels' => $accesslevels]).view('footer');
    }

    public function updateuser($id) {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $role = $this->request->getPost('role');

        $this->model->update($id,[
            'username' => $username,
            'email' => $email,
            'role' => $role
        ]);
        // print_r($data);
        return redirect()->to('/users');
    }

    public function delete($id) {
        $this->model->delete($id);
        return redirect()->to('/users');
    }

    public function login() {
        return view('login');
    }

    public function loginuser() {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = $this->model->find();
        
        $userExists = false;
        foreach ($data as $user) {
            if ($user['email'] === $email) {
                $userid = $user['user_id'];
                $username = $user['username'];
                $useremail = $user['email'];
                $userpassword = $user['password'];
                $role = $user['role'];
                $userExists = true;
                break;
            }
        }
        if ($userExists) {
            $userdata = [
                'id' => $userid,
                'name' => $username,
                'email' => $useremail,
                'password' => $userpassword,
                'role' => $role
            ];
            if($password !== $userdata['password']) {
                return redirect()->to('/login');
                session()->setFlashData('error', 'Invalid password');
            } else {
                $session = session();
                session()->set([
                    'id' => $userdata['id'],
                    'name' => $userdata['name'],
                    'email' => $userdata['email'],
                    'role' => $role,
                ]);

                return redirect()->to('/');
                // echo "user exists";
            }
        } else {
            return redirect()->to('/login');
            session()->setFlashData('error', 'Invalid email');
        }
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}
