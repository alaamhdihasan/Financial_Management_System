<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\UserProfile_M;

class Users_M extends Model
{
    protected $table = 'tb_Users';
    protected $primaryKey = 'U_ID';
    protected $allowedFields = [
        'U_UserName',
        'U_Password',
        'U_State',
        'U_Permission',
        'U_WorkPlace',
        'U_Image',
        'U_UserID'

    ];
    protected $useTimestamps = true;
    protected $createdField = 'U_Created_at';
    protected $updatedField = 'U_Updated_at';


    var $column_order = array(null, 'U_UserName', 'U_State', 'U_Permission'); //set column field database for datatable orderable
    var $order = array('U_ID' => 'asc'); // default order 

    function searchAndDisplay($usersdata = null, $start = 0, $length = 0, $order = null)
    {
        $builder = $this->table("tb_Users");
        if ($usersdata) {
            $arr_usersdata = explode(" ", $usersdata);
            for ($x = 0; $x < count($arr_usersdata); $x++) {
                $builder = $builder->orLike('U_UserName', $arr_usersdata[$x]);
                $builder = $builder->orLike('U_State', $arr_usersdata[$x]);
                $builder = $builder->orLike('U_Permission', $arr_usersdata[$x]);
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

    public function getUsersAndProfile($id)
    {
        $builder = $this->db->table('tb_Users')
            // ->select('U_ID')
            // ->join('tb_Permissions','tb_Permissions.P_ID=tb_Users.U_ID')
            ->where(['U_ID=' => $id])
            ->get()
            ->getResult();

        return $builder;
    }

    public function getUserByUserName($username)
    {
        $builder=$this->table('tb_Users');
        $builder=$builder->where(['U_UserName'=>$username]);
        return $builder->get()->getResult();
    }

    public function getUserPermissions($id)
    {
        $builder=$this->table('tb_Users')->select('*')->join('tb_Permissions','tb_Permissions.P_FK=tb_Users.U_ID');
        $builder=$builder->where(['U_ID'=>$id])
                        ->get()
                        ->getResult();
                        return $builder;
    }

}
