<?php

namespace App\Models;

use CodeIgniter\Model;


class Fm_M extends Model
{
    public $table = 'tb_FuelMoney_01';
    protected $primaryKey = 'Fm_ID';
    protected $allowedFields = [
        'Fm_Number',
        'Fm_Date',
        'Fm_State',
        'Fm_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Fm_Created_at';
    protected $updatedField = 'Fm_Updated_at';


    var $column_order = array(null, 'Fm_Number', 'Fm_Date','Fm_State'); //set column field database for datatable orderable
    var $order = array('Fm_ID' => 'asc'); // default order 

    function searchAndDisplay_Inactive($usersdata = null, $start = 0, $length = 0, $order = null)
    {

        $builder = $this->table('tb_FuelMoney_01');
        $where=array('Fm_State' => 'Inactive');
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);

            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Fm_Number', $arr_usersdata[$x])->where($where);
                $builder = $builder->orLike('Fm_Date', $arr_usersdata[$x])->where($where);
        
            }
        }
        else{
            $builder=$builder->where($where);
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
   

    function searchAndDisplay_Active($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table('tb_FuelMoney_01');
        $where=array('Fm_State' => 'Active');
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);

            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Fm_Number', $arr_usersdata[$x])->where($where);
                $builder = $builder->orLike('Fm_Date', $arr_usersdata[$x])->where($where);

        
            }
        }
        else{
            $builder=$builder->where($where);
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
