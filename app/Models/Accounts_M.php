<?php

namespace App\Models;

use CodeIgniter\Model;


class Accounts_M extends Model
{
    protected $table = 'tb_Accounts';
    protected $primaryKey = 'Ac_ID';
    protected $allowedFields = [
        'Ac_Name',
        'Ac_State',
        'Ac_Group_Sales',
        'Ac_Notes',
        'Ac_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Ac_Created_at';
    protected $updatedField = 'Ac_Updated_at';


    var $column_order = array(null, 'Ac_Name', 'Ac_State','Ac_Group_Sales'); //set column field database for datatable orderable
    var $order = array('Ac_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table("tb_Accounts");
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Ac_Name', $arr_usersdata[$x]);
                $builder = $builder->orLike('Ac_State', $arr_usersdata[$x]);
                $builder = $builder->orLike('Ac_Group_Sales', $arr_usersdata[$x]);
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
