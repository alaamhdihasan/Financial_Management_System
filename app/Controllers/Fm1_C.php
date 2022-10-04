<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Fm1_M;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class FM1_C extends BaseController
{

    // public function index()
    // {
    //     $data['title'] = 'JobCard';


    //     return view('jobcard/Fm', $data);
    // }


    public function fetch()
    {
        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $fuelmoneynumber = $this->request->getGet('getid');

        $Fm1 = new Fm1_M();
        $data = $Fm1->searchAndDisplay($search_value, $start, $length, $order, $fuelmoneynumber);
        $total_count = $Fm1->searchAndDisplay($search_value, $start, $length, $order, $fuelmoneynumber);

        $json_data = array(
            'draw' => intval($param['draw']),
            'recordsTotal' => count($total_count),
            'recordsFiltered' => count($total_count),
            'data' => $data,

        );
        return $this->response->setJSON($json_data);
    }

    public function store()
    {
        $users = new Users_M();;
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);
        $Fm1 = new Fm1_M();
        $data = [
            'Fm1_FK_Fm' => $this->request->getPost('Fm1_FK_Fm'),
            'Fm1_Date' => $this->request->getPost('Fm1_Date'),
            'Fm1_Quantity' => $this->request->getPost('Fm1_Quantity'),
            'Fm1_Money' => $this->request->getPost('Fm1_Money'),
            'Fm1_CarNo' => $this->request->getPost('Fm1_CarNo'),
            'Fm1_CarType' => $this->request->getPost('Fm1_CarType'),
            'Fm1_Meter' => $this->request->getPost('Fm1_Meter'),
            'Fm1_DriverName' => $this->request->getPost('Fm1_DriverName'),
            'Fm1_UserID' => $userinfo['U_ID'],


        ];

        $Fm1->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $Fm1 = new Fm1_M();
        $id = $this->request->getGet('getid');
        $data = [
            'fuelmoney_02' => $Fm1->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $Fm1 = new Fm1_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);;
        $id = $this->request->getPost('Fm1_ID');
        $Fm1->find($id);


        $data = [
            'Fm1_FK_Fm' => $this->request->getPost('Fm1_FK_Fm'),
            'Fm1_Date' => $this->request->getPost('Fm1_Date'),
            'Fm1_Quantity' => $this->request->getPost('Fm1_Quantity'),
            'Fm1_Money' => $this->request->getPost('Fm1_Money'),
            'Fm1_CarNo' => $this->request->getPost('Fm1_CarNo'),
            'Fm1_CarType' => $this->request->getPost('Fm1_CarType'),
            'Fm1_Meter' => $this->request->getPost('Fm1_Meter'),
            'Fm1_DriverName' => $this->request->getPost('Fm1_DriverName'),
            'Fm1_UserID' => $userinfo['U_ID'],

        ];

        $Fm1->update($id, $data);
        $data = ['status' => 'تم تعديل البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $Fm1 = new Fm1_M();

        $id = $this->request->getPost('getid');
        $Fm1->delete($id);

        $data = ['status' => 'تم حذف البيانات'];
        return $this->response->setJSON($data);
    }

    public function filldata()
    {
        $info = new Info_C();
        $data = [
            'getcarno' => $info->getCarNo(),
            'getcartype' => $info->getCarType(),
            'getdrivername' => $info->getDriverName(),
            'getfueltype'=>$info->getFuelType(),
        ];

        return $this->response->setJSON($data);
    }

    public function getCarInformations()
    {
        $info=new Info_C();
        $carno=$this->request->getGet('getcarno');
        $data=[
            'getcarinformations'=>$info->getCarInformations($carno),
        ];
        return $this->response->setJSON($data);

    }

    // public  function total()
    // {
    //     $info = new Info_C();
    //     $jcnum = $this->request->getGet('getid');

    //     $data = [
    //         'gettotal' => $info->getTotalJobCard($jcnum),
    //     ];

    //     return $this->response->setJSON($data);
    // }
    // public  function totaljobcard($idjob)
    // {
    //     $info = new Info_C();
    //     $data=$info->getTotalJobCard($idjob);
    //      return $data;
    // }
}
