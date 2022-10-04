<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Customers_M;

class Customers_C extends BaseController
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
            'title'=> 'الزبائن',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('customers/customers', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $customer = new Customers_M();
        $data = $customer->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $customer->searchAndDisplay($search_value);

    

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

        $customer = new Customers_M();
        $data = [
            'Cu_Name' => $this->request->getPost('cu_name'),
            'Cu_State' => $this->request->getPost('cu_state'),
            'Cu_UserID' => $userinfo['U_ID'],


        ];
        $customer->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
       
    }

    public function edit()
    {
        $customer = new Customers_M();
        $id = $this->request->getGet('getid');
        $data = [
            'customer' => $customer->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $customer =new Customers_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('cu_id');
        $customer->find($id);

        $data = [
            'Cu_Name' => $this->request->getPost('cu_name'),
            'Cu_State' => $this->request->getPost('cu_state'),
            'Cu_UserID' => $userinfo['U_ID'],


        ];
        $customer->update($id, $data);
        $data = ['status' => 'تم تعديل البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $customer = new Customers_M();
        $id = $this->request->getPost('getid');
        $customer->delete($id);
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
