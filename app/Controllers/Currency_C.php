<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Currency_M;
use CodeIgniter\HTTP\Request;
use App\Libraries\Hash;
use monken\TablesIgniter;

class Currency_C extends BaseController
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
            'title'=> 'العملة',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('Currency/currency', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $Currency = new Currency_M();
        $data = $Currency->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $Currency->searchAndDisplay($search_value);

    

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

        $Currency = new Currency_M();
        $data = [
            'Cur_Name' => $this->request->getPost('cur_name'),
            'Cur_State' => $this->request->getPost('cur_state'),
            'Cur_UserID' => $userinfo['U_ID'],


        ];

        $Currency->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
       // return json_encode($data);
    }

    public function edit()
    {
        $Currency = new Currency_M();
        $id = $this->request->getGet('getid');
        $data = [
            'Currency' => $Currency->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $Currency =new Currency_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('Cur_id');
        $Currency->find($id);

        $data = [
            'Cur_Name' => $this->request->getPost('cur_name'),
            'Cur_State' => $this->request->getPost('cur_state'),
            'Cur_UserID' => $userinfo['U_ID'],


        ];
        $Currency->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $Currency = new Currency_M();
        $id = $this->request->getPost('getid');
        $Currency->delete($id);
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
