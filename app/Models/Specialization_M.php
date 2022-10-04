<?php

namespace App\Models;

use CodeIgniter\Model;


class Specialization_M extends Model
{
    protected $table = 'tb_Specialization';
    protected $primaryKey = 'Sp_ID';
    protected $allowedFields = [
        'Sp_Name',
        'Sp_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Sp_Created_at';
    protected $updatedField = 'Sp_Updated_at';


    var $column_order = array(null, 'Sp_Name'); //set column field database for datatable orderable
    var $order = array('Sp_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table("tb_Specialization");
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Sp_Name', $arr_usersdata[$x]);
            }
        }
       
       
        if ($start != 0 or $length != 0) {
            $builder = $builder->limit($length, $start);
        }
        if ($order) { // here order processing
            return  $builder->orderBy($this->column_order[$order['0']['column']], $order['0']['dir'])->get()->getResult();
        } else if (isset($this->order)) {
            $order = $this->order;
            return  $builder->orderBy(key($order), $order[key($order)])->get()->getResult();
        }
        

      

    }

  
}
