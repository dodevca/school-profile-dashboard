<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Files\File;
use App\Models\AuthModel;
use App\Models\DataModel;

date_default_timezone_set('Asia/Jakarta');

class Gallery extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $validation, $session, $auth, $data;
    
    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('gallery');
        $this->session  = session();
        $this->auth     = new \App\Models\AuthModel();
        $this->data     = new \App\Models\DataModel();
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

        $likeArr = [
            'title'
        ];
        
        $query      = $this->request->getGet('query');
        $page       = $this->request->getGet('page') == null ? 1 : (int) $this->request->getGet('page');
        $filter     = $this->request->getGet('filter') == null ? 'terbaru' : $this->request->getGet('filter');
        $orderby    = $filterArr[$filter]['by'];
        $order      = $filterArr[$filter]['order'];
        $limit      = 21;
        $offset     = ($page * $limit) - ($limit + ($page - 1));

        $datas = [
            'currentPage'   => "Galeri",
            'currentSearch' => "album",
            'data'          => [
                'query'         => $query,
                'page'          => $page,
                'filter'        => $filter,
                'search'        => 'gallery',
                'results'       => [],
                'totalResults'  => null
            ]
        ];

        $this->builder->select('album_id, title, description, images, headline, date, views');

        if(!empty($query)) {
            forEach($likeArr as $like) {
                $this->builder->like($like, $query);
            }
        }

        $this->builder->orderBy($orderby, $order);

        $query = $this->builder->get($offset, $limit);

        if(count($query->getResult()) != 0 || !empty($query->getRow())) {
            $datas['data']['totalResults'] = count($query->getResult());

            $loop   = count($query->getResult()) == 21 ? 20 : count($query->getResult());
            $row    = $query->getResult('array');

            for($i = 0; $i < $loop; $i++) {
                $datas['data']['results'][$i]['id']           = $row[$i]['album_id'];
                $datas['data']['results'][$i]['title']        = $row[$i]['title'];
                $datas['data']['results'][$i]['description']  = $row[$i]['description'];
                $datas['data']['results'][$i]['totalImages']  = count(json_decode($row[$i]['images']));
                $datas['data']['results'][$i]['headline']     = $row[$i]['headline'];
                $datas['data']['results'][$i]['date']         = date('d/m/Y', strtotime($row[$i]['date']));
                $datas['data']['results'][$i]['views']        = $row[$i]['views'] == null ? 0 : $row[$i]['views'];
            }
        }

        return view('layouts/gallery-index', $datas);
        // return $this->response->setJSON($datas);
    }
    
    public function add()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $datas = [
            'currentPage' => "Buat Album"
        ];

        return view('layouts/gallery-add', $datas);
    }

    public function edit($albumId)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $action = $this->request->getGet('action') == null ? "preview" : $this->request->getGet('action');

        $datas = [
            'currentPage'   => "Edit Album",
            'action'        => $action,
            'data'          => [
                'result' => null
            ]
        ];

        $tempDatas = json_decode($this->read($albumId, ['album_id', 'title', 'description', 'headline', 'images']), true);

        $datas['data']['result'] = [
            'id'            => $tempDatas['album_id'],
            'title'         => $tempDatas['title'],
            'description'   => $tempDatas['description'],
            'headline'      => $tempDatas['headline'],
            'images'        => json_decode($tempDatas['images'])
        ];

        return view('layouts/gallery-edit', $datas);
    }
    
    public function upload()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules = [
            'album-id'      => 'required',
            'images'        => [
                'rules' => [
                    'uploaded[images]',
                    'mime_in[images,image/jpg,image/jpeg,image/png,image/webp,application/pdf,application/force-download,application/x-download]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, gif, dan atau webp!'
                ]
            ],
        ];

        if($this->validate($rules)) {
            $albumId        = $this->request->getPost('album-id');
            $images         = $this->request->getFiles();
            $tempDatas      = json_decode($this->read($albumId, ['images']), true);
            $imagesName     = json_decode($tempDatas['images']);

            if ($images) {
                foreach ($images['images'] as $img) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $imageName = $img->getRandomName();

                        $img->move('../../homepage/public/uploads/album/', $imageName);
                        array_push($imagesName, $imageName);
                    }
                }
            }

            $datas = [
                'images' => json_encode($imagesName)
            ];

            $this->builder->where('album_id', $albumId);

            if($this->builder->update($datas)) {
                $this->db->close();

                return redirect()->to('galeri/' . $albumId . '?action=edit')->with('success', 'Berhasil memperbarui agenda.');
            } else {
                $this->db->close();

                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        } 

        // return $this->response->setJSON($datas);
    }

    public function create()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules = [
            'title'         => 'required',
            'description'   => 'required',
            'headline'      => [
                'rules' => [
                    'uploaded[headline]',
                    'mime_in[headline,image/jpg,image/jpeg,image/png,image/gif,image/webp]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, gif, dan atau webp!'
                ]
            ],
            'images'        => [
                'rules' => [
                    'uploaded[images]',
                    'mime_in[images,image/jpg,image/jpeg,image/png,image/webp,application/pdf,application/force-download,application/x-download]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, gif, dan atau webp!'
                ]
            ],
        ];

        if($this->validate($rules)) {
            $title          = $this->request->getPost('title');
            $description    = $this->request->getPost('description');
            $headline       = $this->request->getFile('headline');
            $images         = $this->request->getFiles();

            if ($headline && $images) {
                $headlineName   = $headline->getRandomName();
                $imagesName     = [];

                $headline->move('../../homepage/public/uploads/album/', $headlineName);

                foreach ($images['images'] as $img) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $imageName = $img->getRandomName();

                        $img->move('../../homepage/public/uploads/album/', $imageName);
                        array_push($imagesName, $imageName);
                    }
                }
            }

            $datas = [
                'album_id'      => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                'title'         => $title,
                'description'   => $description,
                'headline'      => $headlineName,
                'images'        => json_encode($imagesName)
            ];

            if($this->builder->insert($datas)) {
                $this->db->close();

                return redirect()->to('galeri')->with('success', 'Berhasil menambahkan album baru.');
            } else {
                $this->db->close();

                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // return $this->response->setJSON($datas);
    }

    private function read($albumId, $selectedParams)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $selected   = join(', ', $selectedParams);

        $this->builder->select($selected);

        $query  = $this->builder->getWhere(['album_id' => $albumId]);
        $row    = $query->getRow();

        $this->db->close();

        return $row != null || !empty($row) ? json_encode($row) : null;
    }
    
    public function update()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules = [
            'album-id'      => 'required',
            'title'         => 'required',
            'description'   => 'required',
            'headline'      => 'required',
        ];

        if($this->validate($rules)) {
            $albumId        = $this->request->getPost('album-id');
            $title          = $this->request->getPost('title');
            $description    = $this->request->getPost('description');
            $headline       = $this->request->getPost('headline');
            $tempDatas      = json_decode($this->read($albumId, ['headline', 'images']), true);
            $tempHeadline   = $tempDatas['headline'];
            $images         = json_decode($tempDatas['images']);
            
            array_unshift($images, $tempHeadline);

            if (($key = array_search($headline, $images)) !== false) {
                unset($images[$key]);
            }

            $datas = [
                'title'         => $title,
                'description'   => $description,
                'headline'      => $headline,
                'images'        => json_encode(array_values($images)),
            ];

            $this->builder->where('album_id', $albumId);

            if($this->builder->update($datas)) {
                $this->db->close();

                return redirect()->to('galeri')->with('success', 'Berhasil memperbarui agenda.');
            } else {
                $this->db->close();

                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // return $this->response->setJSON($datas);
    }

    public function delete($id)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $delete = $this->data->deleteRow('gallery', 'album_id', $id);

        if($delete['status']) {
            return redirect()->to('/galeri')->with('success', $delete['message'] . 'album.');
        } else {
            return redirect()->to('/galeri')->with('errors', $delete['message']);
        } 
    }
}
