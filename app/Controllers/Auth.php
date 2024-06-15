<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Auth extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $validation, $auth;
    
    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('users');
        $this->auth     = new \App\Models\AuthModel();
    }

    public function index()
    {
        helper('cookie');

        if($this->auth->isLoggedIn()) {
            return redirect()->to('/');
        }

        if(!empty($this->request->getPost())) {

            $rules = [
                'username'  => 'required',
                'password'  => 'required'
            ];

            if(!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); 
            }

            $username   = $this->request->getPost('username');
            $password   = (string) $this->request->getPost('password');
            $rememberMe = empty($this->request->getPost('rememberMe')) ? false : true;

            $this->builder->select('user_id');
            
            $query = $this->builder->getWhere(['username' => $username, 'password' => md5($password)]);
            
            if(count($query->getResult()) ==  0) {
                return redirect()->back()->withInput()->with('invalid','Nama atau password tidak ditemukkan.'); 
            }

            $data = $this->auth->logIn($query->getRow('user_id'), $username, $password, $rememberMe);

            $this->db->close();
            
            return redirect()->to('/');
            // return $this->response->setJSON($rememberMe);
        }

        $data = [
            'remembered' => get_cookie('rememberAdmin') == null ? null : json_decode(get_cookie('rememberAdmin'), true)
        ];

        return view('login', $data);
        // return $this->response->setJSON($data);
    }

    public function logout() {
        if($this->auth->logOut())
            return redirect()->to('/login');
    }
}