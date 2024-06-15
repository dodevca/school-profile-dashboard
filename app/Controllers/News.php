<?php
namespace App\Controllers;

use CodeIgniter\HTTP\Files\File;
use App\Models\AuthModel;
use App\Models\DataModel;

date_default_timezone_set('Asia/Jakarta');

class News extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $session, $auth, $data;

    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('news');
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
            'currentPage'   => "Berita",
            'currentSearch' => "berita",
            'data'          => [
                'query'         => $query,
                'page'          => $page,
                'filter'        => $filter,
                'search'        => 'news',
                'results'       => [],
                'totalResults'  => null
            ]
        ];

        $this->builder->select('news_id, title, content, image, date, views');

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
                $datas['data']['results'][$i]['id']           = $row[$i]['news_id'];
                $datas['data']['results'][$i]['title']        = $row[$i]['title'];
                $datas['data']['results'][$i]['content']      = $row[$i]['content'];
                $datas['data']['results'][$i]['attachment']   = $row[$i]['image'];
                $datas['data']['results'][$i]['date']         = date('d/m/Y', strtotime($row[$i]['date']));
                $datas['data']['results'][$i]['views']        = $row[$i]['views'] == null ? 0 : $row[$i]['views'];
            }
        }
        
        $this->db->close();

        return view('layouts/news-index', $datas);
        // return $this->response->setJSON($datas);
    }
    
    public function add()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $datas = [
            'currentPage' => "Buat Berita"
        ];

        return view('layouts/news-add', $datas);
    }

    public function edit($newsId)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $datas = [
            'currentPage'   => "Edit Berita",
            'data'          => [
                'result' => null
            ]
        ];

        $tempDatas = json_decode($this->read($newsId, ['news_id', 'title', 'content', 'image']), true);

        $datas['data']['result'] = [
            'id'            => $tempDatas['news_id'],
            'title'         => $tempDatas['title'],
            'content'       => $tempDatas['content'],
            'image'         => $tempDatas['image']
        ];

        return view('layouts/news-edit', $datas);
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
            'image' => [
                'rules' => [
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, atau webp'
                ]
            ],
        ];

        $image = $this->request->getFile('image')->getName() != null ? $this->request->getFile('image') : null;

        if($image == null) {
            if($this->validate($rules1)) {
                $title      = $this->request->getPost('title');
                $content    = $this->request->getPost('content');
    
                $datas = [
                    'news_id'   => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                    'title'     => $title,
                    'content'   => $content
                ];
                
                if($this->builder->insert($datas)) {
                    $this->db->close();
    
                    return redirect()->to('berita')->with('success', 'Berhasil membuat berita baru.');
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
    
                $fileName = $image->getRandomName();
                $image->move('../../homepage/public/uploads/berita/', $fileName);

                $datas = [
                    'news_id'   => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                    'title'     => $title,
                    'content'   => $content,
                    'image'     => $fileName
                ];
                
                if($this->builder->insert($datas)) {
                    $this->db->close();
    
                    return redirect()->to('berita')->with('success', 'Berhasil membuat berita baru.');
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

    private function read($newsId, $selectedParams)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $selected  = join(', ', $selectedParams);

        $this->builder->select($selected);

        $query  = $this->builder->getWhere(['news_id' => $newsId]);
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
            'news-id'   => 'required',
            'title'     => 'required',
            'content'   => 'required'
        ];

        $rules2 = [
            'news-id'   => 'required',
            'title'     => 'required',
            'content'   => 'required',
            'image'     => [
                'rules' => [
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
                ],
                'errors' => [
                    'mime_in' => 'Tipe berkas yang diunggah tidak sesuai. Unggah berkas seperti jpeg, jpg, png, atau webp!'
                ]
            ],
        ];

        $image = $this->request->getFile('image')->getName() != null ? $this->request->getFile('image') : null;

        if($image == null) {
            if($this->validate($rules1)) {
                $newsId     = $this->request->getPost('news-id');
                $title              = $this->request->getPost('title');
                $content            = $this->request->getPost('content');

                $datas = [
                    'title'             => $title,
                    'content'           => $content
                ];

                $this->builder->where('news_id', $newsId);

                if($this->builder->update($datas)) {
                    $this->db->close();

                    return redirect()->to('berita')->with('success', 'Berhasil memperbarui berita.');
                } else {
                    $this->db->close();

                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            if($this->validate($rules2)) {
                $newsId     = $this->request->getPost('news-id');
                $title      = $this->request->getPost('title');
                $content    = $this->request->getPost('content');

                $fileName = $image->getRandomName();
                $image->move('../../homepage/public/uploads/berita/', $fileName);

                $datas = [
                    'title'     => $title,
                    'content'   => $content,
                    'image'     => $fileName
                ];

                $this->builder->where('news_id', $newsId);

                if($this->builder->update($datas)) {
                    $this->db->close();

                    return redirect()->to('berita')->with('success', 'Berhasil memperbarui berita.');
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

        $delete = $this->data->deleteRow('news', 'news_id', $id);

        if($delete['status']) {
            return redirect()->to('/berita')->with('success', $delete['message'] . 'berita.');
        } else {
            return redirect()->to('/berita')->with('errors', $delete['message']);
        } 
    }
}