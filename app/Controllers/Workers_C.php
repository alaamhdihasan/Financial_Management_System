<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Workers_M;
use CodeIgniter\HTTP\Request;
use App\Libraries\Hash;
use monken\TablesIgniter;

class Workers_C extends BaseController
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
            'title'=> 'الفنيين',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('workers/workers', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $workers = new Workers_M();
        $data = $workers->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $workers->searchAndDisplay($search_value);

    

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

        $workers = new Workers_M();
        $data = [
            'Wo_Name' => $this->request->getPost('wo_name'),
            'Wo_State' => $this->request->getPost('wo_state'),
            'Wo_UserID' => $userinfo['U_ID'],


        ];

        $workers->save($data);
        $data = ['status' => 'تم اضافة بيانات الفني بنجاح'];
        return $this->response->setJSON($data);  
    }

    public function edit()
    {
        $workers = new Workers_M();
        $id = $this->request->getGet('getid');
        $data = [
            'workers' => $workers->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $workers =new Workers_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('wo_id');
        $workers->find($id);

        $data = [
            'Wo_Name' => $this->request->getPost('wo_name'),
            'Wo_State' => $this->request->getPost('wo_state'),
            'Wo_UserID' => $userinfo['U_ID'],


        ];
        $workers->update($id, $data);
        $data = ['status' => 'تم تحديث بيانات  الفني بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $workers = new Workers_M();
        $id = $this->request->getPost('getid');
        $workers->delete($id);
        $data = ['status' => 'تم حذف بيانات الفني بنجاح'];
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
