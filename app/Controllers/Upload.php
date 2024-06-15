<?php

namespace App\Controllers;

use App\Models\DataModel;

class Upload extends BaseController
{
    protected $request, $data;

    public function __construct()
    {
        $this->request  = \Config\Services::request();
        $this->data     = new \App\Models\DataModel();
    }

    public function index($cat) {
        $category   = base64_decode($cat);
        $id         = base64_decode((string) $this->request->getGet('id'));
        $item       = base64_decode((string) $this->request->getGet('item'));

        if(!empty($item)) {
            $delete = $this->data->deleteItem($category, $id, $item);
            
            if($delete['status']) {
                return redirect()->back()->with('success', $delete['message']);
            } else {
                return redirect()->back()->with('errors', $delete['message']);
            }
            
            // return $this->response->setJSON($delete); 
        } else {
            return redirect()->back();
        }
    }
}
