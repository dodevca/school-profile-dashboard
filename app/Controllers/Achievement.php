<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Files\File;
use App\Models\AuthModel;
use App\Models\DataModel;

date_default_timezone_set('Asia/Jakarta');

class Achievement extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $validation, $session, $auth, $data;
    
    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('achievements');
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
            'currentPage'   => "Prestasi",
            'data'          => [
                'results'       => [],
                'totalResults'  => null
            ]
        ];

        $this->builder->select('achievement_id, type, name, major, level, year, date');
        $this->builder->orderBy('date', 'DESC');

        $query = $this->builder->get();

        if(count($query->getResult()) != 0 || !empty($query->getRow())) {
            $datas['data']['totalResults'] = count($query->getResult());

            foreach($query->getResult('array') as $key => $row) {
                $datas['data']['results'][$key]['id']       = $row['achievement_id'];
                $datas['data']['results'][$key]['type']     = $row['type'];
                $datas['data']['results'][$key]['name']     = $row['name'];
                $datas['data']['results'][$key]['major']    = $row['major'];
                $datas['data']['results'][$key]['level']    = $row['level'];
                $datas['data']['results'][$key]['year']     = $row['year'];
                $datas['data']['results'][$key]['date']     = date('d/m/Y', strtotime($row['date']));
            }
        }

        return view('layouts/achievement-index', $datas);
        // return $this->response->setJSON($datas);
    }
    
    public function add()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $data = [
            'currentPage' => "Tambah Prestasi"
        ];

        return view('layouts/achievement-add', $data);
    }

    public function edit($achievementId) 
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $datas = [
            'currentPage'   => "Edit Prestasi",
            'data'          => [
                'result' => null
            ]
        ];

        $tempDatas = json_decode($this->read($achievementId, ['achievement_id', 'type', 'name', 'major', 'level', 'year', 'images']), true);

        $datas['data']['result'] = [
            'id'        => $tempDatas['achievement_id'],
            'type'      => $tempDatas['type'],
            'name'      => $tempDatas['name'],
            'major'     => $tempDatas['major'],
            'level'     => $tempDatas['level'],
            'year'      => $tempDatas['year'],
            'images'    => $tempDatas['images'] != null ? json_decode($tempDatas['images']) : null
        ];

        return view('layouts/achievement-edit', $datas);
    }
    
    public function create()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules1 = [
            'type'      => 'required',
            'name'      => 'required',
            'major'     => 'required',
            'level'     => 'required',
            'year'      => 'required'
        ];

        $rules2 = [
            'type'      => 'required',
            'name'      => 'required',
            'major'     => 'required',
            'level'     => 'required',
            'year'      => 'required',
            'images'    => [
                'rules' => [
                    'mime_in[images,image/jpeg,image/gif,image/png,image/jpg,image/webp]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, gif, dan atau webp!'
                ]
            ],
        ];

        $images = $this->request->getFiles();

        if($images['images'][0]->getName() == null) {
            if($this->validate($rules1)) {
                $type   = $this->request->getPost('type');
                $name   = $this->request->getPost('name');
                $major  = $this->request->getPost('major');
                $level  = $this->request->getPost('level');
                $year   = $this->request->getPost('year');

                $datas = [
                    'achievement_id'    => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                    'type'              => $type,
                    'name'              => $name,
                    'major'             => $major,
                    'level'             => $level,
                    'year'              => $year
                ];

                if($this->builder->insert($datas)) {
                    $this->db->close();

                    return redirect()->to('prestasi')->with('success', 'Berhasil menambahkan album baru.');
                } else {
                    $this->db->close();

                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            if($this->validate($rules2)) {
                $type   = $this->request->getPost('type');
                $name   = $this->request->getPost('name');
                $major  = $this->request->getPost('major');
                $level  = $this->request->getPost('level');
                $year   = $this->request->getPost('year');

                if ($images) {
                    $imagesName = [];

                    foreach ($images['images'] as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $imageName = $img->getRandomName();

                            $img->move('../../homepage/public/uploads/prestasi/', $imageName);
                            array_push($imagesName, $imageName);
                        }
                    }
                }

                $datas = [
                    'achievement_id'    => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                    'type'              => $type,
                    'name'              => $name,
                    'major'             => $major,
                    'level'             => $level,
                    'year'              => $year,
                    'images'            => json_encode($imagesName)
                ];

                if($this->builder->insert($datas)) {
                    $this->db->close();

                    return redirect()->to('prestasi')->with('success', 'Berhasil menambahkan album baru.');
                } else {
                    $this->db->close();

                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        // return $this->response->setJSON($datas);
    }
    
    private function read($achievementId, $selectedParams)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $selected   = join(', ', $selectedParams);

        $this->builder->select($selected);

        $query  = $this->builder->getWhere(['achievement_id' => $achievementId]);
        $row    = $query->getRow();

        $this->db->close();

        return $row != null || !empty($row) ? json_encode($row) : null;
    }
    
    public function update()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules1 = [
            'achievement-id'    => 'required',
            'type'              => 'required',
            'name'              => 'required',
            'major'             => 'required',
            'level'             => 'required',
            'year'              => 'required'
        ];

        $rules2 = [
            'achievement-id'    => 'required',
            'type'              => 'required',
            'name'              => 'required',
            'major'             => 'required',
            'level'             => 'required',
            'year'              => 'required',
            'images'    => [
                'rules' => [
                    'mime_in[images,image/jpeg,image/gif,image/png,image/jpg,image/webp]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, gif, dan atau webp!'
                ]
            ],
        ];

        $images = $this->request->getFiles('images');

        if($images['images'][0]->getName() == null) {
            if($this->validate($rules1)) {
                $achievementId  = $this->request->getPost('achievement-id');
                $type           = $this->request->getPost('type');
                $name           = $this->request->getPost('name');
                $major          = $this->request->getPost('major');
                $level          = $this->request->getPost('level');
                $year           = $this->request->getPost('year');
    
                $datas = [
                    'type'              => $type,
                    'name'              => $name,
                    'major'             => $major,
                    'level'             => $level,
                    'year'              => $year
                ];

                $this->builder->where('achievement_id', $achievementId);

                if($this->builder->update($datas)) {
                    $this->db->close();

                    return redirect()->to('prestasi')->with('success', 'Berhasil memperbarui prestasi.');
                } else {
                    $this->db->close();

                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            if($this->validate($rules2)) {
                $achievementId  = $this->request->getPost('achievement-id');
                $type           = $this->request->getPost('type');
                $name           = $this->request->getPost('name');
                $major          = $this->request->getPost('major');
                $level          = $this->request->getPost('level');
                $year           = $this->request->getPost('year');
    
                $tempDatas      = json_decode($this->read($achievementId, ['images']), true);
                $imagesName     = !empty($tempDatas['images']) ? json_decode($tempDatas['images']) : [];

                foreach ($images['images'] as $img) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $imageName = $img->getRandomName();

                        $img->move('../../homepage/public/uploads/prestasi/', $imageName);
                        array_push($imagesName, $imageName);
                    }
                }

                $datas = [
                    'type'              => $type,
                    'name'              => $name,
                    'major'             => $major,
                    'level'             => $level,
                    'year'              => $year,
                    'images'            => json_encode($imagesName)
                ];
                
                $this->builder->where('achievement_id', $achievementId);

                if($this->builder->update($datas)) {
                    $this->db->close();

                    return redirect()->to('prestasi')->with('success', 'Berhasil memperbarui prestasi.');
                } else {
                    $this->db->close();

                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
        
        // return $this->response->setJSON($datas);
    }
    
    public function delete($id)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $delete = $this->data->deleteRow('achievements', 'achievement_id', $id);

        if($delete['status']) {
            return redirect()->to('/prestasi')->with('success', $delete['message'] . 'prestasi.');
        } else {
            return redirect()->to('/prestasi')->withInput()->with('errors', $delete['message']);
        } 
    }
}
