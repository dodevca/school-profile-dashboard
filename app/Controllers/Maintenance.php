<?php

namespace App\Controllers;

class Maintenance extends BaseController
{
    public function index()
    {
        $datas = [
            'currentPage'   => "Pemiliharaan"
        ];

        return view('maintenance', $datas);
    }
}