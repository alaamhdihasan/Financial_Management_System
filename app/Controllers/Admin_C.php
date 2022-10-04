<?php

namespace App\Controllers;
use App\Models\Users_M;

class Admin_C extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
    } 
    public function index()
    {   
        $uesrsModel = new Users_M();
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $uesrsModel->find($loggedUserId);
  
        $data = [
           'userInfo' => $userinfo['U_ID'],
           'userName'=>$userinfo['U_UserName'],
           'title'=>"Dashboard",
        ];
       

        return view('admin/dashboard',$data);
    }
}
