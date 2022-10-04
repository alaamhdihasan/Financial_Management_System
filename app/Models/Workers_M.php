<?php

namespace App\Models;

use CodeIgniter\Model;


class Workers_M extends Model
{
    protected $table = 'tb_Workers';
    protected $primaryKey = 'Wo_ID';
    protected $allowedFields = [
        'Wo_Name',
        'Wo_State',
        'Wo_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Wo_Created_at';
    protected $updatedField = 'Wo_Updated_at';


    var $column_order = array(null, 'Wo_Name', 'Wo_State'); //set column field database for datatable orderable
    var $order = array('Wo_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table("tb_Workers");
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Wo_Name', $arr_usersdata[$x]);
                $builder = $builder->orLike('Wo_State', $arr_usersdata[$x]);

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
