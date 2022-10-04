<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Specialization_M;


class Specialization_C extends BaseController
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
            'title'=> 'الاختصاصات الفنية',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('informations/Specialization', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $Specialization = new Specialization_M();
        $data = $Specialization->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $Specialization->searchAndDisplay($search_value);

    

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

        $Specialization = new Specialization_M();
        $data = [
            'Sp_Name' => $this->request->getPost('sp_name'),
            'Sp_UserID' => $userinfo['U_ID'],


        ];

        $Specialization->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $Specialization = new Specialization_M();
        $id = $this->request->getGet('getid');
        $data = [
            'Specialization' => $Specialization->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $Specialization =new Specialization_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('sp_id');
        $Specialization->find($id);

        $data = [
            'Sp_Name' => $this->request->getPost('sp_name'),
            'Sp_UserID' => $userinfo['U_ID'],


        ];
        $Specialization->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $Specialization = new Specialization_M();
        $id = $this->request->getPost('getid');
        $Specialization->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

  



   
}
