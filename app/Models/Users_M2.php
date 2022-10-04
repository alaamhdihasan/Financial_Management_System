<?php  namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;


class Users_M2
{
    protected $db;
  

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }


   public function noticTable()
    {

         $query = $this->db->table('tb_Users')
         ->get()
         ->getResult();  
        
        return $query;
    }

   

    

}



?>