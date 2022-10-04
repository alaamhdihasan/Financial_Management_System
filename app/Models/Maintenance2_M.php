<?php

namespace App\Models;

use CodeIgniter\Model;


class Maintenance2_M extends Model
{
    protected $table = 'tb_Maintenance_02';
    protected $primaryKey = 'Ma2_ID';
    protected $allowedFields = [
        'Ma2_FK_Ma',
        'Ma2_Date',
        'Ma2_Money',
        'Ma2_CarNo',
        'Ma2_CarType',
        'Ma2_Notes',
        'Ma2_UserID',
        
    ];
    protected $useTimestamps = true;
    protected $createdField = 'Ma2_Created_at';
    protected $updatedField = 'Ma2_Updated_at';


    var $column_order = array(null, 'Ma2_Date','Ma2_CarNo','Ma2_CarType'); //set column field database for datatable orderable
    var $order = array('Ma2_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null,$numberMoney=0)
    {
        $builder = $this->table("tb_Maintenance_02");
       
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Ma2_Date', $arr_usersdata[$x])->where(['Ma2_FK_Ma'=>$numberMoney]);
                $builder = $builder->orLike('Ma2_CarNo', $arr_usersdata[$x])->where(['Ma2_FK_Ma'=>$numberMoney]);
                $builder = $builder->orLike('Ma2_CarType', $arr_usersdata[$x])->where(['Ma2_FK_Ma'=>$numberMoney]);

            }
        }
        else{
            $builder = $builder->where(['Ma2_FK_Ma'=>$numberMoney]);
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
