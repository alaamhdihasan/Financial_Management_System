<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Maintenance1_M;


// use function PHPUnit\Framework\countOf;

class Maintenance_C extends BaseController
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
            'title' => 'سلفة الصيانة',
            'userName' => $userinfo['U_UserName'],
            'title2' => 'تفاصيل السلفة'
        ];
        return view('maintenance/maintenance', $data);
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


        $mastate = $this->request->getGet('maState');
        switch ($mastate) {
            case 'Inactive':
                $ma = new Maintenance1_M();
                $data2 = $ma->searchAndDisplay_Inactive($search_value, $start, $length, $order);
                $total_count2 = $ma->searchAndDisplay_Inactive($search_value);
                $json_data2 = array(
                    'draw' => intval($param['draw']),
                    'recordsTotal' => count($total_count2),
                    'recordsFiltered' => count($total_count2),
                    'data' => $data2
                );
                return $this->response->setJSON($json_data2);
                break;

            case 'Active':
                $ma = new Maintenance1_M();
                $data2 = $ma->searchAndDisplay_Active($search_value, $start, $length, $order);
                $total_count2 = $ma->searchAndDisplay_Active($search_value);
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

        $ma = new Maintenance1_M();
        $data = [
            'Ma_Number' => $this->request->getPost('Ma_Number'),
            'Ma_Date' => $this->request->getPost('Ma_Date'),
            'Ma_State' => $this->request->getPost('Ma_State'),
            'Ma_UserID' => $userinfo['U_ID'],


        ];
        $ma->save($data);
        $data = ['status' => 'تمت الاضافة بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $ma = new Maintenance1_M();
        $id = $this->request->getGet('getid');
        $data = [
            'ma' => $ma->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $ma = new Maintenance1_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('Ma_ID');
        $ma->find($id);

        $data = [
            'Ma_Number' => $this->request->getPost('Ma_Number'),
            'Ma_Date' => $this->request->getPost('Ma_Date'),
            'Ma_State' => $this->request->getPost('Ma_State'),
            'Ma_UserID' => $userinfo['U_ID'],



        ];
        $ma->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $ma = new Maintenance1_M();
        $id = $this->request->getPost('getid');
        $ma->delete($id);
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
            // 'getcustomers' => $info->getCustomers(),

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

    public function getmaxmaintenance()
    {
        $users = new Users_M();;
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);

        $info = new Info_C();
        $data = [
            'getmaxma' => $info->getMaxMaintenance(),

        ];
        return $this->response->setJSON($data);
    }


    
}
