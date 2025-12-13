<?php
namespace App\Models;
use CodeIgniter\Model;

class CommonModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        //$this->db = \Config\Database::connect();
    }

    public function insertData($table,$data)
    {
        return $this->db->table($table)->insert($data);
    }

    public function insertBatchData($table, $data)
    {
        return $this->db->table($table)->insertBatch($data);
    }
    
    
    public function updateData($table,$data,$where){
        return $this->db->table($table)->where($where)->update($data);
    }

    public function getAllData($table, $where=[],$order = [], $limit = null, $random = false){

        $builder = $this->db->table($table);
        if(!empty($where)){
            $builder = $builder->where($where);
        }
        if ($random === true) {
            $builder = $builder->orderBy('RAND()');
        } elseif (!empty($order)) {
            foreach ($order as $key => $value) {
                $builder = $builder->orderBy($key, $value);
            }
        }
        if (!empty($limit)) {
            $builder = $builder->limit($limit);
        }
        return $builder->get()->getResultArray();
    }    
    public function deleteData($tb,$where){
        return $this->db->table($tb)->delete($where);

    }
    

    public function getpagination($where=[], $order = [], $perPage){

        if(!empty($where)){
            $this->where($where);
        }
        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $this->orderBy($key, $value);
            }
        }
        return $this->paginate($perPage);
    }
}