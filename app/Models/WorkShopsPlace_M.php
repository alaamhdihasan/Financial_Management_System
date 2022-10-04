<?php

namespace App\Models;

use CodeIgniter\Model;


class WorkShopsPlace_M extends Model
{
    protected $table = 'tb_WorkShopsPlace';
    protected $primaryKey = 'Wsp_ID';
    protected $allowedFields = [
        'Wsp_Name',
        'Wsp_State',
        'Wsp_Mobile',
        'Wsp_Phone',
        'Wsp_Manager',
        'Wsp_TechnicianCount',
        'Wsp_Description',
        'Wsp_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Wsp_Created_at';
    protected $updatedField = 'Wsp_Updated_at';


    var $column_order = array(null, 'Wsp_Name', 'Wsp_State','Wsp_Mobile', 'Wsp_Manager','Wsp_TechnicianCount'); //set column field database for datatable orderable
    var $order = array('Wsp_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table("tb_WorkShopsPlace");
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Wsp_Name', $arr_usersdata[$x]);
                $builder = $builder->orLike('Wsp_State', $arr_usersdata[$x]);
                $builder = $builder->orLike('Wsp_Manager', $arr_usersdata[$x]);
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
