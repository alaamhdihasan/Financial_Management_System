<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\GroupSaling_M;
use CodeIgniter\HTTP\Request;
use App\Libraries\Hash;
use monken\TablesIgniter;

class GroupSaling_C extends BaseController
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
            'title'=> 'المجموعات',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('groupsaling/groupsaling', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $groupsaling = new GroupSaling_M();
        $data = $groupsaling->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $groupsaling->searchAndDisplay($search_value);

    

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

        $groupsaling = new GroupSaling_M();
        $data = [
            'Gs_Name' => $this->request->getPost('gs_name'),
            'Gs_State' => $this->request->getPost('gs_state'),
            'Gs_Amount' => $this->request->getPost('gs_amount'),
            'Gs_Discount' => $this->request->getPost('gs_discount'),
            'Gs_Notes' => $this->request->getPost('gs_notes'),
            'Gs_UserID' => $userinfo['U_ID'],


        ];

        $groupsaling->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
       
    }

    public function edit()
    {
        $groupsaling = new GroupSaling_M();
        $id = $this->request->getGet('getid');
        $data = [
            'groupsaling' => $groupsaling->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $groupsaling =new GroupSaling_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('gs_id');
        $groupsaling->find($id);

        $data = [
            'Gs_Name' => $this->request->getPost('gs_name'),
            'Gs_State' => $this->request->getPost('gs_state'),
            'Gs_Amount' => $this->request->getPost('gs_amount'),
            'Gs_Discount' => $this->request->getPost('gs_discount'),
            'Gs_Notes' => $this->request->getPost('gs_notes'),
            'Gs_UserID' => $userinfo['U_ID'],


        ];
        $groupsaling->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $groupsaling = new GroupSaling_M();
        $id = $this->request->getPost('getid');
        $groupsaling->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function filldata()
    {
        $info= new Info_C();
        $data=[
            'getstate'=>$info->getState(),
            
        ];

        return $this->response->setJSON($data);
    }



   
}
