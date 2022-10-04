<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Account_M;


class Account_C extends BaseController
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
            'title'=> 'الحساب',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('informations/account', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $account = new Account_M();
        $data = $account->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $account->searchAndDisplay($search_value);

    

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

        $account = new Account_M();
        $data = [
            'Ac_Name' => $this->request->getPost('Ac_name'),
            'Ac_UserID' => $userinfo['U_ID'],


        ];

        $account->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $account = new Account_M();
        $id = $this->request->getGet('getid');
        $data = [
            'account' => $account->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $account =new Account_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('Ac_id');
        $account->find($id);

        $data = [
            'Ac_Name' => $this->request->getPost('Ac_name'),
            'Ac_UserID' => $userinfo['U_ID'],


        ];
        $account->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $account = new Account_M();
        $id = $this->request->getPost('getid');
        $account->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

  



   
}
