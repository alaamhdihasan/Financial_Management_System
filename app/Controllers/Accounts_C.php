<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Accounts_M;
use CodeIgniter\HTTP\Request;
use App\Libraries\Hash;
use monken\TablesIgniter;

class Accounts_C extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        $uesrsModel = new Users_M();
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $uesrsModel->find($loggedUserId);
        $data=[
            'title'=>'الحسابات',
            'userName'=>$userinfo['U_UserName']
        ];



        return view('accounts/accounts', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $accounts = new Accounts_M();
        $data = $accounts->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $accounts->searchAndDisplay($search_value);

    

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

        $accounts = new Accounts_M();
        $data = [
            'Ac_Name' => $this->request->getPost('ac_name'),
            'Ac_State' => $this->request->getPost('ac_state'),
            'Ac_Group_Sales' => $this->request->getPost('ac_group_sales'),
            'Ac_Notes' => $this->request->getPost('ac_notes'),
            'Ac_UserID' => $userinfo['U_ID'],


        ];

        $accounts->save($data);
        $data = ['status' => 'تم اضافة الحساب بنجاح'];
        return $this->response->setJSON($data);
       // return json_encode($data);
    }

    public function edit()
    {
        $accounts = new Accounts_M();
        $id = $this->request->getGet('getid');
        $data = [
            'accounts' => $accounts->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $accounts =new Accounts_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('ac_id');
        $accounts->find($id);

        $data = [
            'Ac_Name' => $this->request->getPost('ac_name'),
            'Ac_State' => $this->request->getPost('ac_state'),
            'Ac_Group_Sales' => $this->request->getPost('ac_group_sales'),
            'Ac_Notes' => $this->request->getPost('ac_notes'),
            'Ac_UserID' => $userinfo['U_ID'],


        ];
        $accounts->update($id, $data);
        $data = ['status' => 'تم تحديث الحساب بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $accounts = new Accounts_M();
        $id = $this->request->getPost('getid');
        $accounts->delete($id);
        $data = ['status' => 'تم حذف الحساب بنجاح'];
        return $this->response->setJSON($data);
    }

    public function filldata()
    {
        $info= new Info_C();
        $data=[
            'getstate'=>$info->getState(),
            'getgroupsales'=>$info->getGroupSales(),
            
        ];

        return $this->response->setJSON($data);
    }



   
}
