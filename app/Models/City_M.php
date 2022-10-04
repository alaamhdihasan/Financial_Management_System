<?php

namespace App\Models;

use CodeIgniter\Model;


class City_M extends Model
{
    protected $table = 'tb_City';
    protected $primaryKey = 'Ci_ID';
    protected $allowedFields = [
        'Ci_Name',
        'Ci_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Ci_Created_at';
    protected $updatedField = 'Ci_Updated_at';


    var $column_order = array(null, 'Ci_Name'); //set column field database for datatable orderable
    var $order = array('Ci_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table("tb_City");
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Ci_Name', $arr_usersdata[$x]);
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
