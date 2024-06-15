<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $session;

    public function __construct()
    {
        $this->session = session();        
    }

    public function isLoggedIn()
    {
        helper('cookie');

        $isLoggedIn = false;

        if($this->session->has('isLoggedInAdmin'))
            $isLoggedIn = true;

        return $isLoggedIn;
    }

    public function logIn($userId, $username, $password, $remember)
    {
        $config = config('App');

        if($remember) {
            $data = [
                'username'  => $username,
                'password'  => $password
            ];

            set_cookie('rememberAdmin', json_encode($data), 30 * 24 * 60 * 60, $config->cookieDomain, $config->cookiePath, '', $config->cookieSecure, $config->cookieHTTPOnly, $config->cookieSameSite);
        } else {
            delete_cookie('rememberAdmin');
        }
        
        $this->session->set([
            'isLoggedInAdmin'  => $userId
        ]);
        
        return true;
    }

    public function logOut()
    {
        $this->session->remove([
            'isLoggedInAdmin'
        ]);
    
        return true;
    }
}