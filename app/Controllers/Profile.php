<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Profile extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $session, $auth;

    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('users');
        $this->auth     = new \App\Models\AuthModel();
        $this->session  = session(); 
    }

    public function index()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $datas = [
            'currentPage'   => "Profil",
            'data'          => [
            ]
        ];

        $userId = $this->session->get('isLoggedInAdmin');

        $this->builder->select('username, as, date');
        $this->builder->limit(1);

        $query = $this->builder->getWhere(['user_id' => $userId]);

        $datas['data']['username']  = $query->getRow('username');
        $datas['data']['as']        = $query->getRow('as');
        $datas['data']['date']      = $query->getRow('date');

        $this->db->close();
        
        return view('layouts/profile-index', $datas);
        // return $this->response->setJSON($datas);
    }

    public function password()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules = [
            'password'          => 'required|matches[password-match]',
            'password-match'    => 'required',
        ];

        if($this->validate($rules)) {
            $newPassword    = (string) $this->request->getPost('password');
            $userId         = $this->session->get('isLoggedInAdmin');

            $this->builder->set('password', md5($newPassword));
            $this->builder->where('user_id', $userId);

            if($this->builder->update()) {
                if($this->auth->logOut())
                    return redirect()->to('/login');
            } else {
                return redirect()->back()->withInput()->with('errors', 'Maaf, terjadi kesalahan. Password gagal diperbaharui.');
            }

        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function username()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules = [
            'username'  => 'required|is_unique[users.username]',
            'password'  => 'required',
        ];

        if($this->validate($rules)) {
            $newUsername    = $this->request->getPost('username');
            $password       = (string) $this->request->getPost('password');
            $userId         = $this->session->get('isLoggedInAdmin');

            $this->builder->set('username', $newUsername);
            $this->builder->where(['user_id' => $userId, 'password' => md5($password)]);

            if($this->builder->update()) {
                return redirect()->back()->withInput()->with('success', 'Berhasil memperbaharui username');
            } else {
                return redirect()->back()->withInput()->with('errors', 'Maaf, terjadi kesalahan. Password gagal diperbaharui.');
            }

        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}