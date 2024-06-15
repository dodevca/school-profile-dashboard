<?php
namespace App\Controllers;

class EventSubmission extends BaseController
{
    public function index()
    {
        $data = [
            'currentPage' => "Pengajuan Agenda"
        ];

        return view('layouts/event-submission', $data);
    }
}