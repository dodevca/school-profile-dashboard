<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Files\File;
use App\Models\AuthModel;

date_default_timezone_set('Asia/Jakarta');

class Alumni extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $validation, $session, $auth;
    
    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('achievements');
        $this->session  = session();
        $this->auth     = new \App\Models\AuthModel();
    }
    
    public function index()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $filterArr = [
            'a-z'       => [
                'by'    => 'title',
                'order' => 'ASC'
            ],
            'z-a'       => [
                'by'    => 'title',
                'order' => 'DESC'
            ],
            'terbaru'   => [
                'by'    => 'date',
                'order' => 'DESC'
            ],
            'terlama'   => [
                'by'    => 'date',
                'order' => 'ASC'
            ]
        ];
        
        $page       = $this->request->getGet('page') == null ? 1 : (int) $this->request->getGet('page');
        $filter     = $this->request->getGet('filter') == null ? 'terbaru' : $this->request->getGet('filter');
        $orderby    = $filterArr[$filter]['by'];
        $order      = $filterArr[$filter]['order'];
        $limit      = 21;
        $offset     = ($page * $limit) - ($limit + ($page - 1));

        $datas = [
            'currentPage'   => "Ikatan Alumni",
            'currentSearch' => "alumni",
            'data'          => [
                'page'          => $page,
                'filter'        => $filter,
                'search'        => 'alumni',
                'results'       => [],
                'totalResults'  => null
            ]
        ];

        return view('layouts/alumni-index', $datas);
    }
    
    public function edit()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $data = [
            'currentPage' => "Edit Data Alumni",
        ];

        return view('layouts/alumni-edit', $data);
    }
}
