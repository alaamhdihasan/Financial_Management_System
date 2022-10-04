<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Fm_M;


// use function PHPUnit\Framework\countOf;

class Fm_C extends BaseController
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
        $data = [
            'title' => 'سلفة الوقود',
            'userName' => $userinfo['U_UserName'],
            'title2' => 'تفاصيل السلفة'
        ];
        return view('fuelMoney/fuelMoney', $data);
    }


    public function fetch()
    {
        $users = new Users_M();;
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);

        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';


        $fmState = $this->request->getGet('fmState');
        switch ($fmState) {
            case 'Inactive':
                $fm = new Fm_M();
                $data2 = $fm->searchAndDisplay_Inactive($search_value, $start, $length, $order);
                $total_count2 = $fm->searchAndDisplay_Inactive($search_value);
                $json_data2 = array(
                    'draw' => intval($param['draw']),
                    'recordsTotal' => count($total_count2),
                    'recordsFiltered' => count($total_count2),
                    'data' => $data2
                );
                return $this->response->setJSON($json_data2);
                break;

            case 'Active':
                $fm = new Fm_M();
                $data2 = $fm->searchAndDisplay_Active($search_value, $start, $length, $order);
                $total_count2 = $fm->searchAndDisplay_Active($search_value);
                $json_data2 = array(
                    'draw' => intval($param['draw']),
                    'recordsTotal' => count($total_count2),
                    'recordsFiltered' => count($total_count2),
                    'data' => $data2
                );
                return $this->response->setJSON($json_data2);
                break;


            default:

                break;
        }
    }

    public function store()
    {
        $users = new Users_M();
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);

        $Fm = new Fm_M();
        $data = [
            'Fm_Number' => $this->request->getPost('Fm_Number'),
            'Fm_Date' => $this->request->getPost('Fm_Date'),
            'Fm_State' => $this->request->getPost('Fm_State'),
            'Fm_UserID' => $userinfo['U_ID'],


        ];
        $Fm->save($data);
        $data = ['status' => 'تمت الاضافة بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $Fm = new Fm_M();
        $id = $this->request->getGet('getid');
        $data = [
            'Fm' => $Fm->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $Fm = new Fm_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('Fm_ID');
        $Fm->find($id);

        $data = [
            'Fm_Number' => $this->request->getPost('Fm_Number'),
            'Fm_Date' => $this->request->getPost('Fm_Date'),
            'Fm_State' => $this->request->getPost('Fm_State'),
            'Fm_UserID' => $userinfo['U_ID'],



        ];
        $Fm->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $Fm = new Fm_M();
        $id = $this->request->getPost('getid');
        $Fm->delete($id);
        $data = ['status' => 'تم حذف البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function filldata()
    {
        $info = new Info_C();
        $data = [
            'getstate' => $info->getState(),
            'getcarno' => $info->getCarNo(),
            'getcartype' => $info->getCarType(),
            'getcustomers' => $info->getCustomers(),

        ];

        return $this->response->setJSON($data);
    }

    public function getcustomer()
    {
        $info = new Info_C();
        $customername = $this->request->getGet('getname');

        $data = [
            'getcustomerinfo' => $info->getCustomersByName($customername),

        ];

        return $this->response->setJSON($data);
    }
    public function getCarInformations()
    {
        $info = new Info_C();
        $carno = $this->request->getGet('getcarno');

        $data = [
            'getcarinformations' => $info->getCarInformations($carno),

        ];

        return $this->response->setJSON($data);
    }

    public function getmaxfuel()
    {
        $users = new Users_M();;
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);

        $info = new Info_C();
        $data = [
            'getmaxFm' => $info->getMaxFm(),

        ];
        return $this->response->setJSON($data);
    }


    
}
