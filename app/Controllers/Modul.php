<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Files\File;
use App\Models\AuthModel;
use App\Models\DataModel;

date_default_timezone_set('Asia/Jakarta');

class Modul extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $validation, $session, $auth, $data;
    
    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('moduls');
        $this->session  = session();
        $this->auth     = new \App\Models\AuthModel();
        $this->data     = new \App\Models\DataModel();
    }

    public function index()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $datas = [
            'currentPage'   => "Modul",
            'data'          => [
                'results'       => [],
                'totalResults'  => null
            ]
        ];

        $this->builder->select('modul_id, title, major, writer, teacher, modul, date');
        $this->builder->orderBy('date', 'DESC');

        $query = $this->builder->get();

        if(count($query->getResult()) != 0 || !empty($query->getRow())) {
            $datas['data']['totalResults'] = count($query->getResult());

            foreach($query->getResult('array') as $key => $row) {
                $datas['data']['results'][$key]['id']       = $row['modul_id'];
                $datas['data']['results'][$key]['title']    = $row['title'];
                $datas['data']['results'][$key]['major']    = $row['major'];
                $datas['data']['results'][$key]['writer']   = $row['writer'];
                $datas['data']['results'][$key]['teacher']  = $row['teacher'];
                $datas['data']['results'][$key]['modul']    = $row['modul'];
                $datas['data']['results'][$key]['date']     = date('d/m/Y', strtotime($row['date']));
            }
        }

        return view('layouts/modul-index', $datas);
    }
    
    public function add()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $data = [
            'currentPage' => "Tambah Modul"
        ];

        return view('layouts/modul-add', $data);
    }

    public function edit($modulId)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $datas = [
            'currentPage'   => "Edit Modul",
            'data'          => [
                'result' => null
            ]
        ];

        $tempDatas = json_decode($this->read($modulId, ['modul_id', 'title', 'major', 'writer', 'teacher', 'tags', 'modul']), true);

        $datas['data']['result'] = [
            'id'        => $tempDatas['modul_id'],
            'title'     => $tempDatas['title'],
            'major'     => $tempDatas['major'],
            'writer'    => $tempDatas['writer'],
            'teacher'   => $tempDatas['teacher'],
            'tags'      => implode(', ', json_decode($tempDatas['tags'])),
            'modul'     => $tempDatas['modul']
        ];

        return view('layouts/modul-edit', $datas);
        // return $this->response->setJSON($datas);
    }
    
    public function create()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules = [
            'title'     => 'required',
            'major'     => 'required',
            'writer'    => 'required',
            'teacher'   => 'required',
            'modul'     => [
                'rules' => [
                    'uploaded[modul]',
                    'mime_in[modul,application/pdf,application/force-download,application/x-download,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas dengan jenis seperti pdf, doc, docx, ppt, pptx, xls, atau xlsx!'
                ]
            ],
        ];

        if($this->validate($rules)) {
            $title      = $this->request->getPost('title');
            $major      = (string) $this->request->getPost('major');
            $writer     = (string) $this->request->getPost('writer');
            $teacher    = (string) $this->request->getPost('teacher');
            $modul      = $this->request->getFile('modul');
            $temTags    = explode(',', (string) $this->request->getPost('tags'));
            $tags       = [];

            if ($modul) {
                $fileName = $title . ' (' . ucwords($major) . ') - ' . ucwords($teacher) . '.' . pathinfo($modul, PATHINFO_EXTENSION);

                $modul->move('../../homepage/public/uploads/modul/', $fileName);
            }

            foreach($temTags as $key => $tag) {
                $tags[$key] = trim($tag);
            }

            $modulIdUnsluged = str_replace(' ', '-', $major) . ' ' . str_replace(' ', '-', $writer) . ' ' . str_replace(' ', '-', $teacher) . ' ' . date('d-m-Y');

            $datas = [
                'modul_id'  => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                'title'     => $title,
                'major'     => $major,
                'writer'    => $writer,
                'teacher'   => $teacher,
                'modul'     => $fileName,
                'tags'      => json_encode($tags)
            ];

            if($this->builder->insert($datas)) {
                $this->db->close();

                return redirect()->to('modul')->with('success', 'Berhasil menambahkan album baru.');
            } else {
                $this->db->close();

                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // return $this->response->setJSON($datas);
    }

    private function read($modulId, $selectedParams)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $selected   = join(', ', $selectedParams);

        $this->builder->select($selected);

        $query  = $this->builder->getWhere(['modul_id' => $modulId]);
        $row    = $query->getRow();

        $this->db->close();

        return $row != null || !empty($row) ? json_encode($row) : null;
    }
    
    public function delete($id)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $delete = $this->data->deleteRow('moduls', 'modul_id', $id);

        if($delete['status']) {
            return redirect()->to('/modul')->with('success', $delete['message'] . 'modul.');
        } else {
            return redirect()->to('/modul')->withInput()->with('errors', $delete['message']);
        } 
    }
}
