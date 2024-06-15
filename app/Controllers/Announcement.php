<?php
namespace App\Controllers;

use CodeIgniter\HTTP\Files\File;
use App\Models\AuthModel;
use App\Models\DataModel;

date_default_timezone_set('Asia/Jakarta');

class Announcement extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $session, $auth, $data;

    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('announcements');
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
            'terbaru'   => 'DESC',
            'terlama'   => 'ASC'
        ];
        
        $likeArr = [
            'title'
        ];

        $query  = $this->request->getGet('query');
        $page   = $this->request->getGet('page') == null ? 1 : (int) $this->request->getGet('page');
        $filter = $this->request->getGet('filter') == null ? 'terbaru' : $this->request->getGet('filter');
        $order  = $filterArr[$filter];
        $limit  = 21;
        $offset = ($page * $limit) - ($limit + ($page - 1));

        $datas = [
            'currentPage'   => "Pengumuman",
            'currentSearch' => "pengumuman",
            'data'          => [
                'query'         => $query,
                'page'          => $page,
                'filter'        => $filter,
                'search'        => 'announcements',
                'results'       => [],
                'totalResults'  => null
            ]
        ];

        $this->builder->select('announcement_id, title, content, attachment, important, date, views');

        if(!empty($query)) {
            forEach($likeArr as $like) {
                $this->builder->orLike($like, $query);
            }
        }

        $this->builder->orderBy('date', $order);
        
        $query = $this->builder->get($offset, $limit);

        if(count($query->getResult()) != 0 || !empty($query->getRow())) {
            $datas['data']['totalResults'] = count($query->getResult());

            $loop   = count($query->getResult()) == 21 ? 20 : count($query->getResult());
            $row    = $query->getResult('array');

            for($i = 0; $i < $loop; $i++) {
                $datas['data']['results'][$i]['id']           = $row[$i]['announcement_id'];
                $datas['data']['results'][$i]['title']        = $row[$i]['title'];
                $datas['data']['results'][$i]['content']      = $row[$i]['content'];
                $datas['data']['results'][$i]['attachment']   = $row[$i]['attachment'];
                $datas['data']['results'][$i]['important']    = $row[$i]['important'];
                $datas['data']['results'][$i]['date']         = date('d/m/Y', strtotime($row[$i]['date']));
                $datas['data']['results'][$i]['views']        = $row[$i]['views'] == null ? 0 : $row[$i]['views'];
            }
        }
        
        $this->db->close();

        return view('layouts/announcement-index', $datas);
        // return $this->response->setJSON($datas);
    }
    
    public function add()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $datas = [
            'currentPage' => "Buat Pengumuman"
        ];

        return view('layouts/announcement-add', $datas);
    }

    public function edit($announcementId)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $datas = [
            'currentPage'   => "Edit Pengumuman",
            'data'          => [
                'result' => null
            ]
        ];

        $tempDatas = json_decode($this->read($announcementId, ['announcement_id', 'title', 'content', 'attachment', 'important']), true);

        $datas['data']['result'] = [
            'id'            => $tempDatas['announcement_id'],
            'title'         => $tempDatas['title'],
            'content'       => $tempDatas['content'],
            'attachment'    => $tempDatas['attachment'],
            'important'     => $tempDatas['important'],
        ];

        return view('layouts/announcement-edit', $datas);
        // return $this->response->setJSON($datas);
    }

    public function create()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules1 = [
            'title'     => 'required',
            'content'   => 'required'
        ];

        $rules2 = [
            'title'     => 'required',
            'content'   => 'required',
            'attachment' => [
                'rules' => [
                    'mime_in[attachment,image/jpg,image/jpeg,image/png,image/webp,application/pdf,application/force-download,application/x-download]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, webp, atau pdf!'
                ]
            ],
        ];

        $attachment = $this->request->getFile('attachment')->getName() != null ? $this->request->getFile('attachment') : null;

        if($attachment == null) {
            if($this->validate($rules1)) {
                $title      = $this->request->getPost('title');
                $content    = $this->request->getPost('content');
                $important  = $this->request->getPost('important') ? 1 : 0;
    
                $datas = [
                    'announcement_id'   => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                    'title'             => $title,
                    'content'           => $content,
                    'important'         => $important,
                ];
                
                if($this->builder->insert($datas)) {
                    $this->db->close();
    
                    return redirect()->to('pengumuman')->with('success', 'Berhasil membuat pengumuman baru.');
                } else {
                    $this->db->close();
    
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            if($this->validate($rules2)) {
                $title      = $this->request->getPost('title');
                $content    = $this->request->getPost('content');
                $important  = $this->request->getPost('important') ? 1 : 0;
    
                $fileName = $attachment->getRandomName();
                $attachment->move('../../homepage/public/uploads/pengumuman/', $fileName);

                $datas = [
                    'announcement_id'   => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                    'title'             => $title,
                    'content'           => $content,
                    'attachment'        => $fileName,
                    'important'         => $important
                ];
                
                if($this->builder->insert($datas)) {
                    $this->db->close();
    
                    return redirect()->to('pengumuman')->with('success', 'Berhasil membuat pengumuman baru.');
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

    private function read($announcementId, $selectedParams)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $selected  = join(', ', $selectedParams);

        $this->builder->select($selected);

        $query  = $this->builder->getWhere(['announcement_id' => $announcementId]);
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
            'announcement-id'   => 'required',
            'title'             => 'required',
            'content'           => 'required'
        ];

        $rules2 = [
            'announcement-id'   => 'required',
            'title'             => 'required',
            'content'           => 'required',
            'attachment'        => [
                'rules' => [
                    'mime_in[attachment,image/jpg,image/jpeg,image/png,image/webp,application/pdf,application/force-download,application/x-download]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, webp, atau pdf!'
                ]
            ],
        ];

        $attachment = $this->request->getFile('attachment')->getName() != null ? $this->request->getFile('attachment') : null;

        if($attachment == null) {
            if($this->validate($rules1)) {
                $announcementId     = $this->request->getPost('announcement-id');
                $title              = $this->request->getPost('title');
                $content            = $this->request->getPost('content');
                $important          = $this->request->getPost('important') ? 1 : 0;

                $datas = [
                    'title'             => $title,
                    'content'           => $content,
                    'important'         => $important
                ];

                $this->builder->where('announcement_id', $announcementId);

                if($this->builder->update($datas)) {
                    $this->db->close();

                    return redirect()->to('pengumuman')->with('success', 'Berhasil memperbarui pengumuman.');
                } else {
                    $this->db->close();

                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            if($this->validate($rules2)) {
                $announcementId     = $this->request->getPost('announcement-id');
                $title              = $this->request->getPost('title');
                $content            = $this->request->getPost('content');
                $important          = $this->request->getPost('important') ? 1 : 0;

                $fileName = $attachment->getRandomName();
                $attachment->move('../../homepage/public/uploads/pengumuman/', $fileName);

                $datas = [
                    'title'             => $title,
                    'content'           => $content,
                    'attachment'        => $fileName,
                    'important'         => $important
                ];

                $this->builder->where('announcement_id', $announcementId);

                if($this->builder->update($datas)) {
                    $this->db->close();

                    return redirect()->to('pengumuman')->with('success', 'Berhasil memperbarui pengumuman.');
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

        $delete = $this->data->deleteRow('announcements', 'announcement_id', $id);

        if($delete['status']) {
            return redirect()->to('/pengumuman')->with('success', $delete['message'] . 'pengumuman.');
        } else {
            return redirect()->to('/pengumuman')->with('errors', $delete['message']);
        } 
    }
}
