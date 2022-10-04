<?php

namespace App\Models;

use CodeIgniter\Model;


class Fm1_M extends Model
{
    protected $table = 'tb_FuelMoney_02';
    protected $primaryKey = 'Fm1_ID';
    protected $allowedFields = [
        'Fm1_FK_Fm',
        'Fm1_Date',
        'Fm1_Quantity',
        'Fm1_Money',
        'Fm1_CarNo',
        'Fm1_CarType',
        'Fm1_Meter',
        'Fm1_DriverName',
        'Fm1_UserID',
        
    ];
    protected $useTimestamps = true;
    protected $createdField = 'Fm1_Created_at';
    protected $updatedField = 'Fm1_Updated_at';


    var $column_order = array(null, 'Fm1_Date','Fm1_CarNo','Fm1_CarType'); //set column field database for datatable orderable
    var $order = array('Fm1_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null,$numberMoney=0)
    {
        $builder = $this->table("tb_FuelMoney_02");
       
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Fm1_Date', $arr_usersdata[$x])->where(['Fm1_FK_Fm'=>$numberMoney]);
                $builder = $builder->orLike('Fm1_CarNo', $arr_usersdata[$x])->where(['Fm1_FK_Fm'=>$numberMoney]);
                $builder = $builder->orLike('Fm1_CarType', $arr_usersdata[$x])->where(['Fm1_FK_Fm'=>$numberMoney]);

            }
        }
        else{
            $builder = $builder->where(['Fm1_FK_Fm'=>$numberMoney]);
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
