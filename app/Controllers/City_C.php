<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\City_M;


class City_C extends BaseController
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
            'title'=> 'المدينة',
            'userName'=> $userinfo['U_UserName'],
            ] ;


        return view('informations/city', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $City = new City_M();
        $data = $City->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $City->searchAndDisplay($search_value);

    

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

        $City = new City_M();
        $data = [
            'Ci_Name' => $this->request->getPost('ci_name'),
            'Ci_UserID' => $userinfo['U_ID'],


        ];

        $City->save($data);
        $data = ['status' => 'تمت اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $City = new City_M();
        $id = $this->request->getGet('getid');
        $data = [
            'City' => $City->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $City =new City_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('ci_id');
        $City->find($id);

        $data = [
            'Ci_Name' => $this->request->getPost('ci_name'),
            'Ci_UserID' => $userinfo['U_ID'],


        ];
        $City->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $City = new City_M();
        $id = $this->request->getPost('getid');
        $City->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

  



   
}
