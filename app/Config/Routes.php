<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

$routes->get('auth', 'Auth::index');
$routes->get('auth/logout', 'Auth::logout');

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {


    $routes->get('admins', 'Admin_C::index');
    //routes of Users.
    $routes->get('users', 'Users_C::index');
    $routes->get('users-fetch', 'Users_C::fetch');
    $routes->post('users-store', 'Users_C::store');
    $routes->get('users-edit', 'Users_C::edit');
    $routes->get('users-edit2', 'Users_C::edit2');
    $routes->post('users-update', 'Users_C::update');
    $routes->post('users-delete', 'Users_C::delete');
    $routes->get('users-filldata', 'Users_C::filldata');
    $routes->get('users-getPermissions', 'Users_C::getUsersPermission');

    //user profile.
    $routes->get('userprofile-fetch', 'UsersProfile_C::index');
    $routes->get('userprofile-fetch2', 'UsersProfile_C::index2');
    $routes->get('userprofile-fetch3', 'UsersProfile_C::fetch');
    $routes->post('userprofile-update', 'UsersProfile_C::update');

    // workshop ..
    $routes->get('workshopplace', 'WorkShopsPlace_C::index');
    $routes->get('workshopplace-fetch', 'WorkShopsPlace_C::fetch');
    $routes->get('workshopplace-filldata', 'WorkShopsPlace_C::filldata');
    $routes->post('workshopplace-store', 'WorkShopsPlace_C::store');
    $routes->get('workshopplace-edit', 'WorkShopsPlace_C::edit');
    $routes->post('workshopplace-update', 'WorkShopsPlace_C::update');
    $routes->post('workshopplace-delete', 'WorkShopsPlace_C::delete');

    // Workers ..
    $routes->get('workers', 'Workers_C::index');
    $routes->get('workers-fetch', 'Workers_C::fetch');
    $routes->get('workers-filldata', 'Workers_C::filldata');
    $routes->post('workers-store', 'Workers_C::store');
    $routes->get('workers-edit', 'Workers_C::edit');
    $routes->post('workers-update', 'Workers_C::update');
    $routes->post('workers-delete', 'Workers_C::delete');

     // FuelTye..
     $routes->get('fueltype', 'FuelType_C::index');
     $routes->get('fueltype-fetch', 'FuelType_C::fetch');
     $routes->get('fueltype-filldata', 'FuelType_C::filldata');
     $routes->post('fueltype-store', 'FuelType_C::store');
     $routes->get('fueltype-edit', 'FuelType_C::edit');
     $routes->post('fueltype-update', 'FuelType_C::update');
     $routes->post('fueltype-delete', 'FuelType_C::delete');
     $routes->get('fueltype-getfuelprice', 'FuelType_C::getprice');

    // State...
    $routes->get('state', 'State_C::index');
    $routes->get('state-fetch', 'State_C::fetch');
    $routes->post('state-store', 'State_C::store');
    $routes->get('state-edit', 'State_C::edit');
    $routes->post('state-update', 'State_C::update');
    $routes->post('state-delete', 'State_C::delete');

    // Account...
    $routes->get('account', 'Account_C::index');
    $routes->get('account-fetch', 'Account_C::fetch');
    $routes->post('account-store', 'Account_C::store');
    $routes->get('account-edit', 'Account_C::edit');
    $routes->post('account-update', 'Account_C::update');
    $routes->post('account-delete', 'Account_C::delete');



    // Permission..
    $routes->get('permission', 'Permission_C::index');
    $routes->get('permission-fetch', 'Permission_C::fetch');
    $routes->post('permission-store', 'Permission_C::store');
    $routes->get('permission-edit', 'Permission_C::edit');
    $routes->post('permission-update', 'Permission_C::update');
    $routes->post('permission-delete', 'Permission_C::delete');

    // CarType..
    $routes->get('cartype', 'CarType_C::index');
    $routes->get('cartype-fetch', 'CarType_C::fetch');
    $routes->post('cartype-store', 'CarType_C::store');
    $routes->get('cartype-edit', 'CarType_C::edit');
    $routes->post('cartype-update', 'CarType_C::update');
    $routes->post('cartype-delete', 'CarType_C::delete');


    // Customers..
    $routes->get('customer', 'Customers_C::index');
    $routes->get('customer-fetch', 'Customers_C::fetch');
    $routes->get('customer-filldata', 'Customers_C::filldata');
    $routes->post('customer-store', 'Customers_C::store');
    $routes->get('customer-edit', 'Customers_C::edit');
    $routes->post('customer-update', 'Customers_C::update');
    $routes->post('customer-delete', 'Customers_C::delete');

    // Workers..
    $routes->get('workers', 'Workers_C::index');
    $routes->get('workers-fetch', 'Workers_C::fetch');
    $routes->get('workers-filldata', 'Workers_C::filldata');
    $routes->post('workers-store', 'Workers_C::store');
    $routes->get('workers-edit', 'Workers_C::edit');
    $routes->post('workers-update', 'Workers_C::update');
    $routes->post('workers-delete', 'Workers_C::delete');


    // FuelMoney_01..
    $routes->get('fuelMoney', 'Fm_C::index');
    $routes->get('fuelMoney-fetch', 'Fm_C::fetch');
    $routes->get('fuelMoney-filldata', 'Fm_C::filldata');
    $routes->post('fuelMoney-store', 'Fm_C::store');
    $routes->get('fuelMoney-edit', 'Fm_C::edit');
    $routes->post('fuelMoney-update', 'Fm_C::update');
    $routes->post('fuelMoney-delete', 'Fm_C::delete');
    $routes->get('fuelMoney-getcustomer', 'Fm_C::getcustomer');
    $routes->get('fuelMoney-getcarinformations', 'Fm_C::getCarInformations');
    $routes->get('fuelMoney-maxfuel', 'Fm_C::getmaxfuel');

    // FuelMoney_02..
    $routes->get('fm1-fetch', 'Fm1_C::fetch');
    $routes->get('fm1-filldata', 'Fm1_C::filldata');
    $routes->post('fm1-store', 'Fm1_C::store');
    $routes->get('fm1-edit', 'Fm1_C::edit');
    $routes->post('fm1-update', 'Fm1_C::update');
    $routes->post('fm1-delete', 'Fm1_C::delete');
    $routes->get('fm1-total', 'Fm1_C::total');
    $routes->get('fm1-getcarinformations', 'Fm1_C::getCarInformations');

     // Maintenance_01..
     $routes->get('maintenance', 'Maintenance_C::index');
     $routes->get('maintenance-fetch', 'Maintenance_C::fetch');
     $routes->get('maintenance-filldata', 'Maintenance_C::filldata');
     $routes->post('maintenance-store', 'Maintenance_C::store');
     $routes->get('maintenance-edit', 'Maintenance_C::edit');
     $routes->post('maintenance-update', 'Maintenance_C::update');
     $routes->post('maintenance-delete', 'Maintenance_C::delete');
     $routes->get('maintenance-getcustomer', 'Maintenance_C::getcustomer');
     $routes->get('maintenance-getcarinformations', 'Maintenance_C::getCarInformations');
     $routes->get('maintenance-maxmaintenance', 'Maintenance_C::getmaxmaintenance');

     // Maintenance_02..
    $routes->get('maintenance2-fetch', 'Maintenance2_C::fetch');
    $routes->get('maintenance2-filldata', 'Maintenance2_C::filldata');
    $routes->post('maintenance2-store', 'Maintenance2_C::store');
    $routes->get('maintenance2-edit', 'Maintenance2_C::edit');
    $routes->post('maintenance2-update', 'Maintenance2_C::update');
    $routes->post('maintenance2-delete', 'Maintenance2_C::delete');
    $routes->get('maintenance2-total', 'Maintenance2_C::total');
    $routes->get('maintenance2-getcarinformations', 'Maintenance2_C::getCarInformations');
 

    // Reports...
    $routes->get('reports', 'Reports_C::index');
    $routes->get('printfuelmoney', 'Reports_C::printFuelMoney');
    $routes->get('datainfo', 'Reports_C::dataone');
    $routes->get('datamaintenance', 'Reports_C::dataMaintenance');
    $routes->get('printMaintenance', 'Reports_C::printMaintenance');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
