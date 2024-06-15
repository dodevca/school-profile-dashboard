<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function deleteRow($table, $identifier, $indentified)
    {
        $builder = $this->db->table($table);

        $data = [
            'status'    => false,
            'message'   => null
        ];

        $builder->where($identifier, $indentified);
        
        if($builder->delete()) {
            $data['status']     = true;
            $data['message']    = 'Berhasil menghapus ';
        }

        $this->db->close();
        
        return $data;
    }

    public function deleteItem($table, $id, $item)
    {
        $builder    = $this->db->table($table);
        $newArr     = [];

        $data = [
            'status'    => false,
            'message'   => null
        ];

        $identifier = [
            'gallery'       => 'album_id',
            'achievements'  => 'achievement_id'
        ];

        $builder->select('images');

        $query = $builder->getWhere([$identifier[$table] => $id]);

        if(count($query->getResult()) != 0 || !empty($query->getRow())) {
            $images = json_decode($query->getRow('images'));

            forEach($images as $image) {
                if($image != $item) {
                    array_push($newArr, $image);
                }
            }
        }

        $builder->resetQuery();

        if(!empty($newArr)) {
            $builder->where($identifier[$table], $id);

            if($builder->update(['images' => json_encode(array_values($newArr))])) {
                $data['status']     = true;
                $data['message']    = 'Berhasil menghapus file.';
            }

            $this->db->close();
        } else {
            $data['status']     = false;
            $data['message']    = ['Sisakan minimal 1 file.'];
        }

        return $data;
        // return $query->getResult('array');
    }
}