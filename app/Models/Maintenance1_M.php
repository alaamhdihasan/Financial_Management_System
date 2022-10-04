<?php

namespace App\Models;

use CodeIgniter\Model;


class Maintenance1_M extends Model
{
    public $table = 'tb_Maintenance_01';
    protected $primaryKey = 'Ma_ID';
    protected $allowedFields = [
        'Ma_Number',
        'Ma_Date',
        'Ma_State',
        'Ma_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'Ma_Created_at';
    protected $updatedField = 'Ma_Updated_at';


    var $column_order = array(null, 'Ma_Number', 'Ma_Date','Ma_State'); //set column field database for datatable orderable
    var $order = array('Ma_ID' => 'asc'); // default order 

    function searchAndDisplay_Inactive($usersdata = null, $start = 0, $length = 0, $order = null)
    {

        $builder = $this->table('tb_Maintenance_01');
        $where=array('Ma_State' => 'Inactive');
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);

            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Ma_Number', $arr_usersdata[$x])->where($where);
                $builder = $builder->orLike('Ma_Date', $arr_usersdata[$x])->where($where);
        
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
        $builder = $this->table('tb_Maintenance_01');
        $where=array('Ma_State' => 'Active');
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);

            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('Ma_Number', $arr_usersdata[$x])->where($where);
                $builder = $builder->orLike('Ma_Date', $arr_usersdata[$x])->where($where);

        
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
