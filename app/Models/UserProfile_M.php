<?php namespace App\Models;

use CodeIgniter\Model;



class UserProfile_M extends Model
{
    protected $table='tb_Permissions';
    protected $primaryKey ='P_ID';
    protected $allowedFields=[
        'P_FK',
        'P_Create',
        'P_Update',
        'P_Delete',
        'P_Dashboard',
        'P_Users', 
        'P_Reports',
        'P_State',
        'P_Permission',
        'P_CarType',
        'P_WorkShopPlace',
        'P_Workers',
        'P_Accounts',
        'P_Customers',
        'P_FuelType',
        'P_FuelMoney',
        'P_Maintenance',
        'P_UserID',


    ];
    protected $useTimestamps = true;
    protected $createdField = 'P_Created_at';
    protected $updatedField = 'P_Updated_at';

    

}

?>