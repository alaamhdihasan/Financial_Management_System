<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Permission_M;


class Permission_C extends BaseController
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
        $data=[
            'title'=> 'الصلاحيات',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('informations/permission', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $permission = new Permission_M();
        $data = $permission->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $permission->searchAndDisplay($search_value);

    

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
        $users = new Users_M();;
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);

        $permission = new Permission_M();
        $data = [
            'Pe_Name' => $this->request->getPost('Pe_name'),
            'Pe_UserID' => $userinfo['U_ID'],


        ];

        $permission->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $permission = new Permission_M();
        $id = $this->request->getGet('getid');
        $data = [
            'permission' => $permission->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $permission =new Permission_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('Pe_id');
        $permission->find($id);

        $data = [
            'Pe_Name' => $this->request->getPost('Pe_name'),
            'Pe_UserID' => $userinfo['U_ID'],


        ];
        $permission->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $permission = new Permission_M();
        $id = $this->request->getPost('getid');
        $permission->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

  



   
}
