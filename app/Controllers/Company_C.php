<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Company_M;


class Company_C extends BaseController
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
            'title'=> 'الشركات',
            'userName'=>$userinfo['U_UserName']
            ] ;
        


        return view('informations/Company', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $Company = new Company_M();
        $data = $Company->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $Company->searchAndDisplay($search_value);

    

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

        $Company = new Company_M();
        $data = [
            'Co_Name' => $this->request->getPost('co_name'),
            'Co_UserID' => $userinfo['U_ID'],


        ];

        $Company->save($data);
        $data = ['status' => 'تمت اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $Company = new Company_M();
        $id = $this->request->getGet('getid');
        $data = [
            'Company' => $Company->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $Company =new Company_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('Co_id');
        $Company->find($id);

        $data = [
            'Co_Name' => $this->request->getPost('co_name'),
            'Co_UserID' => $userinfo['U_ID'],


        ];
        $Company->update($id, $data);
        $data = ['status' => 'تم تعديل البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $Company = new Company_M();
        $id = $this->request->getPost('getid');
        $Company->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

  



   
}
