<?php
namespace App\Controllers;

class AlumniSubmission extends BaseController
{
    public function index()
    {
        $data = [
            'currentPage' => "Pengajuan Data Alumni",
        ];

        return view('layouts/alumni-submission', $data);
    }
}