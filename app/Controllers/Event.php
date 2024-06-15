<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\DataModel;

date_default_timezone_set('Asia/Jakarta');

class Event extends BaseController
{
    protected $helpers = ['form'];
    protected $db, $request, $builder, $validation, $session, $auth, $data;

    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->builder  = $this->db->table('events');
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
            'mendatang'             => 'ASC',
            'terbaru'               => 'DESC',
            'terlama'               => 'ASC'
        ];
        
        $likeArr = [
            'name',
            'description'
        ];
        
        $query  = $this->request->getGet('query');
        $page   = $this->request->getGet('page') == null ? 1 : (int) $this->request->getGet('page');
        $filter = $this->request->getGet('filter') == null ? 'terbaru' : $this->request->getGet('filter');
        $order  = $filterArr[$filter];
        $limit  = 21;
        $offset = ($page * $limit) - ($limit + ($page - 1));

        $datas = [
            'currentPage'   => "Agenda",
            'currentSearch' => "agenda",
            'data'          => [
                'query'         => $query,
                'page'          => $page,
                'filter'        => $filter,
                'search'        => 'events',
                'results'       => [],
                'totalResults'  => null
            ]
        ];

        $this->builder->select('event_id, name, description, date_start, date_end, date, views');

        if(!empty($query)) {
            forEach($likeArr as $like) {
                $this->builder->orLike($like, $query);
            }
        }
        
        if($filter == 'mendatang') {
            $now = date('Y-m-d H-i-s');

            $this->builder->where(['date_start >=' => $now, 'date_end <=' => $now]);
            $this->builder->orderBy('date_start', $order);
        } else {
            $this->builder->orderBy('date', $order);
        }

        $query = $this->builder->get($offset, $limit);

        if(count($query->getResult()) != 0 || !empty($query->getRow())) {
            $datas['data']['totalResults'] = count($query->getResult());
            
            $loop   = count($query->getResult()) == 21 ? 20 : count($query->getResult());
            $row    = $query->getResult('array');

            for($i = 0; $i < $loop; $i++) {
                $datas['data']['results'][$i]['id']           = $row[$i]['event_id'];
                $datas['data']['results'][$i]['name']         = $row[$i]['name'];
                $datas['data']['results'][$i]['description']  = $row[$i]['description'];
                $datas['data']['results'][$i]['dateStart']    = date('d/m/Y H:i', strtotime($row[$i]['date_start']));
                $datas['data']['results'][$i]['dateEnd']      = date('d/m/Y H:i', strtotime($row[$i]['date_end']));
                $datas['data']['results'][$i]['date']         = date('d/m/Y', strtotime($row[$i]['date']));
                $datas['data']['results'][$i]['views']        = $row[$i]['views'] == null ? 0 : $row[$i]['views'];
            }
        }
        
        $this->db->close();

        return view('layouts/event-index', $datas);
    }
    
    public function add()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }

        $datas = [
            'currentPage' => "Buat Agenda"
        ];

        return view('layouts/event-add', $datas);
    }

    public function edit($eventId)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $datas = [
            'currentPage'   => "Edit Agenda",
            'data'          => [
                'result' => null
            ]
        ];

        $tempDatas = json_decode($this->read($eventId, ['event_id', 'name', 'description', 'date_start', 'date_end']), true);

        $datas['data']['result'] = [
            'id'            => $tempDatas['event_id'],
            'name'          => $tempDatas['name'],
            'description'   => $tempDatas['description'],
            'dateStart'     => date('Y-m-d', strtotime($tempDatas['date_start'])),
            'dateEnd'       => date('Y-m-d', strtotime($tempDatas['date_end'])),
            'timeStart'     => date('H:i', strtotime($tempDatas['date_start'])),
            'timeEnd'       => date('H:i', strtotime($tempDatas['date_end']))
        ];

        return view('layouts/event-edit', $datas);
        // return $this->response->setJSON($datas);
    }

    public function create()
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
            'date-start'    => 'required',
            'date-end'      => 'required',
            'time-start'    => 'required',
            'time-end'      => 'required'
        ];

        if($this->validate($rules)) {
            $name           = $this->request->getPost('name');
            $description    = $this->request->getPost('description');
            $dateStart      = $this->request->getPost('date-start');
            $dateEnd        = $this->request->getPost('date-end');
            $timeStart      = $this->request->getPost('time-start');
            $timeEnd        = $this->request->getPost('time-end');
            $started        = date('Y-m-d H:i:s', strtotime($dateStart . ' ' . $timeStart));;
            $ended          = date('Y-m-d H:i:s', strtotime($dateEnd . ' ' . $timeEnd));;

            $datas = [
                'event_id'      => preg_replace('/\D/', '', date('Y/m/d H:i:s.u')),
                'name'          => $name,
                'description'   => $description,
                'date_start'    => $started,
                'date_end'      => $ended
            ];

            if($this->builder->insert($datas)) {
                $this->db->close();

                return redirect()->to('agenda')->with('success', 'Berhasil menambahkan agenda baru.');
            } else {
                $this->db->close();

                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // return $this->response->setJSON($datas);
    }

    private function read($eventId, $selectedParams)
    {
        if(!$this->auth->isLoggedIn()) {
            return redirect()->to('login');
        }
        
        $selected   = join(', ', $selectedParams);

        $this->builder->select($selected);

        $query  = $this->builder->getWhere(['event_id' => $eventId]);
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
            'event-id'      => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'date-start'    => 'required',
            'date-end'      => 'required',
            'time-start'    => 'required',
            'time-end'      => 'required'
        ];

        if($this->validate($rules)) {
            $eventId        = $this->request->getPost('event-id');
            $name           = $this->request->getPost('name');
            $description    = $this->request->getPost('description');
            $dateStart      = $this->request->getPost('date-start');
            $dateEnd        = $this->request->getPost('date-end');
            $timeStart      = $this->request->getPost('time-start');
            $timeEnd        = $this->request->getPost('time-end');
            $started        = date('Y-m-d H:i:s', strtotime($dateStart . ' ' . $timeStart));;
            $ended          = date('Y-m-d H:i:s', strtotime($dateEnd . ' ' . $timeEnd));;

            $datas = [
                'name'          => $name,
                'description'   => $description,
                'date_start'    => $started,
                'date_end'      => $ended
            ];

            $this->builder->where('event_id', $eventId);

            if($this->builder->update($datas)) {
                $this->db->close();

                return redirect()->to('agenda')->with('success', 'Berhasil memperbarui agenda.');
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

        $delete = $this->data->deleteRow('events', 'event_id', $id);

        if($delete['status']) {
            return redirect()->to('/agenda')->with('success', $delete['message'] . 'agenda.');
        } else {
            return redirect()->to('/agenda')->with('errors', $delete['message']);
        } 
    }
}
