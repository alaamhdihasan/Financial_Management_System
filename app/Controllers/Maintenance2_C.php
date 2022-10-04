<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\Maintenance2_M;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class Maintenance2_C extends BaseController
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

        $Ma2 = new Maintenance2_M();
        $data = $Ma2->searchAndDisplay($search_value, $start, $length, $order, $fuelmoneynumber);
        $total_count = $Ma2->searchAndDisplay($search_value, $start, $length, $order, $fuelmoneynumber);

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
        $Ma2 = new Maintenance2_M();
        $data = [
            'Ma2_FK_Ma' => $this->request->getPost('Ma2_FK_Ma'),
            'Ma2_Date' => $this->request->getPost('Ma2_Date'),
            'Ma2_Money' => $this->request->getPost('Ma2_Money'),
            'Ma2_CarNo' => $this->request->getPost('Ma2_CarNo'),
            'Ma2_CarType' => $this->request->getPost('Ma2_CarType'),
            'Ma2_Notes' => $this->request->getPost('Ma2_Notes'),
            'Ma2_UserID' => $userinfo['U_ID'],


        ];

        $Ma2->save($data);
        $data = ['status' => 'تم اضافة البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function edit()
    {
        $Ma2 = new Maintenance2_M();
        $id = $this->request->getGet('getid');
        $data = [
            'maintenance2' => $Ma2->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $Ma2 = new Maintenance2_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);;
        $id = $this->request->getPost('Ma2_ID');
        $Ma2->find($id);


        $data = [
            'Ma2_FK_Ma' => $this->request->getPost('Ma2_FK_Ma'),
            'Ma2_Date' => $this->request->getPost('Ma2_Date'),
            'Ma2_Money' => $this->request->getPost('Ma2_Money'),
            'Ma2_CarNo' => $this->request->getPost('Ma2_CarNo'),
            'Ma2_CarType' => $this->request->getPost('Ma2_CarType'),
            'Ma2_Notes' => $this->request->getPost('Ma2_Notes'),
            'Ma2_UserID' => $userinfo['U_ID'],

        ];

        $Ma2->update($id, $data);
        $data = ['status' => 'تم تعديل البيانات بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $Ma2 = new Maintenance2_M();

        $id = $this->request->getPost('getid');
        $Ma2->delete($id);

        $data = ['status' => 'تم حذف البيانات'];
        return $this->response->setJSON($data);
    }

    public function filldata()
    {
        $info = new Info_C();
        $data = [
            'getcarno' => $info->getCarNo(),
            'getcartype' => $info->getCarType(),
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
