<?php

namespace App\Controllers;

class Info_C extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function getState()
    {

        $data = $this->db->query("Sp_GetState")->getResult();
        return $data;
    }


    public function getPermission()
    {

        $data = $this->db->query("Sp_GetPermission")->getResult();
        return $data;
    }
    public function getWorkingPlace()
    {

        $data = $this->db->query("Sp_GetWorkingPlace")->getResult();
        return $data;
    }

    public function getCustomers()
    {

        $data = $this->db->query("Sp_GetCustomers")->getResult();
        return $data;
    }

    public function getCustomersByName($name)
    {
        $data = $this->db->query("Sp_GetCustomersByName @name ='" . $name . "' ")->getResult();
        return $data;
    }

    public function getMaxFm()
    {

        $data = $this->db->query("Sp_GetMaxFm")->getResult();
        return $data;
    }
    public function getMaxMaintenance()
    {

        $data = $this->db->query("Sp_GetMaxMaintenance")->getResult();
        return $data;
    }
    public function getFuelType()
    {

        $data = $this->db->query("Sp_GetFuelType")->getResult();
        return $data;
    }
    public function getFuelTypeSpecific($num)
    {
        $data = $this->db->query("Sp_GetFuelTypeSpecific @fueltypespecific ='" . $num . "' ")->getResult();
        return $data;
    }

    public function getFuelMoney($num)
    {
        $data = $this->db->query("Sp_FuelMoneyPrint @fuelmoneynumber ='" . $num . "' ")->getResult();
        return $data;
    }

    public function getFuelMoneyTotal($num)
    {
        $data = $this->db->query("Sp_FuelMoneyTotal @fuelmoneynumber ='" . $num . "' ")->getResult();
        return $data;
    }
    public function getFuelMoneyTotal2($num)
    {
        $data = $this->db->query("Sp_FuelMoneyTotal2 @fuelmoneynumber ='" . $num . "' ")->getResult();
        return $data;
    }

    public function getMaintenance($num)
    {
        $data = $this->db->query("Sp_MaintenancePrint @maintenancenumber ='" . $num . "' ")->getResult();
        return $data;
    }

    public function getMaintenanceTotal($num)
    {
        $data = $this->db->query("Sp_MaintenanceTotal @maintenancenumber ='" . $num . "' ")->getResult();
        return $data;
    }
    public function getMaintenanceTotal2($num)
    {
        $data = $this->db->query("Sp_MaintenanceTotal2 @maintenancenumber ='" . $num . "' ")->getResult();
        return $data;
    }

    

    // Here is the connection With Another Database ....

    // stored procedurs of inventory database

    public function getCarInformations($carno)
    {
        $db2 = db_connect('another');
        $data = $db2->query("Sp_GetCarInformations @carno='" . $carno . "'")->getResult();
        return $data;
    }
    
    public function getCarType()
    {
        $db2 = db_connect('another');
        $data = $db2->query("Sp_GetCarType")->getResult();
        return $data;
    }
    public function getCarNo()
    {
        $db2 = db_connect('another');
        $data = $db2->query("Sp_GetCarNo")->getResult();
        return $data;
    }
    public function getDriverName()
    {
        $db2 = db_connect('another2');
        $data = $db2->query("GetNameEmployee")->getResult();
        return $data;
    }
}
