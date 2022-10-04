<?php

namespace App\Models;

use CodeIgniter\Model;


class GroupSaling_M extends Model
{
    protected $table = 'tb_GroupSaling';
    protected $primaryKey = 'Gs_ID';
    protected $allowedFields = [
        'Gs_Name',
        'Gs_State',
        'Gs_Amount',
        'Gs_Discount',
        'Gs_Notes',
        'Gs_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Gs_Created_at';
    protected $updatedField = 'Gs_Updated_at';


    var $column_order = array(null, 'Gs_Name', 'Gs_State','Gs_Amount', 'Gs_Discount'); //set column field database for datatable orderable
    var $order = array('Gs_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table("tb_GroupSaling");
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Gs_Name', $arr_usersdata[$x]);
                $builder = $builder->orLike('Gs_State', $arr_usersdata[$x]);
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
