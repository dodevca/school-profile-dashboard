<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Home extends BaseController
{
    protected $db, $auth, $session;

    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->auth     = new \App\Models\AuthModel();
        $this->session  = session();
    }

    public function index()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $datas = [
            'currentPage'   => "Dashboard",
            'data'          => [
                'admin'         => null,
                'announcement'  => 0,
                'modul'         => 0,
                'event'         => 0,
                'news'          => 0
            ]
        ];

        $userQuery              = $this->db->query("SELECT username FROM users");
        $datas['data']['admin'] = $userQuery->getRow('username');

        $newsQuery              = $this->db->query("SELECT count(id) as total FROM news");
        $datas['data']['news']  = $newsQuery->getRow('total');

        $announcementQuery              = $this->db->query("SELECT count(id) as total FROM announcements");
        $datas['data']['announcement']  = $announcementQuery->getRow('total');

        $modulQuery             = $this->db->query("SELECT count(id) as total FROM moduls");
        $datas['data']['modul'] = $modulQuery->getRow('total');

        $eventQuery                     = $this->db->query("SELECT count(id) as total FROM events");
        $datas['data']['event']         = $eventQuery->getRow('total');

        $this->db->close();

        return view('layouts/dashboard', $datas);
    }
}
