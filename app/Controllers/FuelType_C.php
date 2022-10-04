<?php

namespace App\Controllers;

use App\Models\Users_M;
use App\Models\FuelType_M;


class FuelType_C extends BaseController
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
            'title'=> 'انواع الوقود ',
            'userName'=>$userinfo['U_UserName']
            ] ;


        return view('informations/fueltype', $data);
    }


    public function fetch()
    {


        $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';
        $search_value = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

        $fueltype = new FuelType_M();
        $data = $fueltype->searchAndDisplay($search_value, $start, $length, $order);
        $total_count = $fueltype->searchAndDisplay($search_value);

    

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

        $fueltype = new FuelType_M();
        $data = [
            'Ft_Name' => $this->request->getPost('Ft_Name'),
            'Ft_Price' => $this->request->getPost('Ft_Price'),
            'Ft_State' => $this->request->getPost('Ft_State'),
            'Ft_UserID' => $userinfo['U_ID'],


        ];

        $fueltype->save($data);
        $data = ['status' => 'تم اضافة البيانات  بنجاح'];
        return $this->response->setJSON($data);
       
    }

    public function edit()
    {
        $fueltype = new FuelType_M();
        $id = $this->request->getGet('getid');
        $data = [
            'fueltype' => $fueltype->find($id),
        ];

        return $this->response->setJSON($data);
    }

    public function update()
    {
        $users = new Users_M();
        $fueltype =new FuelType_M();
        $loggedUserId = session()->get('loggedUser');

        $userinfo = $users->find($loggedUserId);
        $id = $this->request->getPost('Ft_id');
        $fueltype->find($id);

        $data = [
            'Ft_Name' => $this->request->getPost('Ft_Name'),
            'Ft_Price' => $this->request->getPost('Ft_Price'),
            'Ft_State' => $this->request->getPost('Ft_State'),
            'Ft_UserID' => $userinfo['U_ID'],
        ];
        $fueltype->update($id, $data);
        $data = ['status' => 'تم تحديث البيانات  بنجاح'];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $fueltype = new FuelType_M();
        $id = $this->request->getPost('getid');
        $fueltype->delete($id);
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
    
    public function getprice()
    {
        $fueltypespecific=$this->request->getGet('getfueltype');
        $info=new Info_C();
        $data=[
            'getfuelprice'=>$info->getFuelTypeSpecific($fueltypespecific),
        ];
        return $this->response->setJSON($data);
    }


   
}
