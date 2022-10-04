<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Libraries\Hash;
use App\Models\UserProfile_M;


class Users_C extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        $users = new Users_M();
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);
        $data['title'] = 'المستخدمون';
        $data['table'] = '';
        $data['userName'] = $userinfo['U_UserName'];

        return view('admin/users/users', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $usersdata = new Users_M();
        $data = $usersdata->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $usersdata->searchAndDisplay($search_value);

    

        $json_data = array(
            'draw' => intval($param['draw']),
            'recordsTotal' => count($total_count),
            'recordsFiltered' => count($total_count),
            'data' => $data
            
        );
        
        
         return $this->response->setJSON($json_data);
    }

    public function store()
    {
        $users = new Users_M();
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);
        $password = $this->request->getPost('u_password');

        $profile=new UserProfile_M();
        $data = [
            'U_UserName' => $this->request->getPost('u_username'),
            'U_Password' => Hash::make($password),
            'U_State' => $this->request->getPost('u_state'),
            'U_Permission' => $this->request->getPost('u_permission'),
            'U_WorkPlace' => $this->request->getPost('U_WorkPlace'),
            'U_UserID' => $userinfo['U_ID'],


        ];

        $users->save($data);
        $username=$this->request->getPost('u_username');
        $userid=$this->getUserIDByUserName($username);
        $dataprofile=[
            'P_FK'=>$userid[0]->U_ID,
            'P_Create'=>'False',
            'P_Update'=>'False',
            'P_Delete'=>'False',
            'P_Dashboard'=>'False',
            'P_Users'=>'False',
            'P_Reports'=>'False',
            'P_State'=>'False',
            'P_Permission'=>'False',
            'P_CarType'=>'False',
            'P_WorkShopPlace'=>'False',
            'P_Workers'=>'False',
            'P_Accounts'=>'False',
            'P_Customers'=>'False', 
            'P_FuelType'=>'False', 
            'P_FuelMoney'=>'False', 
            'P_Maintenance'=>'False', 
            'P_UserID'=>$userinfo['U_ID'],
        ];
        $profile->save($dataprofile);

        $data = ['status' => 'تم اضافة بيانات  المستخدم بنجاح'];
        return $this->response->setJSON($data);
        // return json_encode($data);
    }

    public function edit()
    {
        $users = new Users_M();
        $id = $this->request->getGet('getid');
        $data = [
            'users' => $users->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('u_id');
        $users->find($id);
        $data = [
            'U_UserName' => $this->request->getPost('u_username'),
            'U_Password' => $this->request->getPost('u_password'),
            'U_State' => $this->request->getPost('u_state'),
            'U_Permission' => $this->request->getPost('u_permission'),
            'U_WorkPlace' => $this->request->getPost('U_WorkPlace'),
            'U_UserID' => $userinfo['U_ID'],


        ];
        $users->update($id, $data);
        $data = ['status' => 'تم تحديث بيانات   المستخدم بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $users = new Users_M();
        $id = $this->request->getPost('getid');
        $users->delete($id);
        $data = ['status' => 'تم حذف بيانات المستخدم بنجاح'];
        return $this->response->setJSON($data);
    }

    public function filldata()
    {
        $info= new Info_C();
        $data=[
            'getstate'=>$info->getState(),
            'getpermission'=>$info->getPermission(),
            'getworkplace'=>$info->getWorkingPlace(),
        ];

        return $this->response->setJSON($data);
    }

    public function getUserIDByUserName($username)
    {
       $user=new Users_M();
       $query=$user->getUserByUserName($username);
       
       return $query;
    }



    public function getUserType()
    {
        $uesrsModel = new Users_M();
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $uesrsModel->find($loggedUserId);

        $data = [
            'userInfo' => $userinfo['U_ID']
        ];

        return $data;
    }

    public function getUsersPermission()
    {
        $users = new Users_M();
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);
        $getPermissions=$users->getUserPermissions($userinfo['U_ID']);
        return $this->response->setJSON($getPermissions);

    }
}
