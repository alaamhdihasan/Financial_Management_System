<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\CarType_M;


class CarType_C extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        $users = new Users_M();;
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);
        $data=[
            'title' => 'انواع العجلات',
            'userName'=>$userinfo['U_UserName'],
        ];


        return view('informations/cartype', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $CarType = new CarType_M();
        $data = $CarType->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $CarType->searchAndDisplay($search_value);

    

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

        $CarType = new CarType_M();
        $data = [
            'Ct_Name' => $this->request->getPost('ct_name'),
            'Ct_Price' => $this->request->getPost('ct_price'),
            'Ct_UserID' => $userinfo['U_ID'],


        ];

        $CarType->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $CarType = new CarType_M();
        $id = $this->request->getGet('getid');
        $data = [
            'carType' => $CarType->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $CarType =new CarType_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('ct_id');
        $CarType->find($id);

        $data = [
            'Ct_Name' => $this->request->getPost('ct_name'),
            'Ct_Price' => $this->request->getPost('ct_price'),
            'Ct_UserID' => $userinfo['U_ID'],


        ];
        $CarType->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $CarType = new CarType_M();
        $id = $this->request->getPost('getid');
        $CarType->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

  



   
}
