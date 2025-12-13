<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->match(['get', 'post'], '/shop/(:any)', 'Home::shop/$1');
$routes->get('/contact', 'Home::contact');
$routes->match(['get', 'post'], '/message', 'Home::message');
$routes->match(['get', 'post'], '/subscribe', 'Home::subscribe');
$routes->match(['get', 'post'], '/registration_here', 'UserController::registration_here');
$routes->match(['get', 'post'], '/login_here', 'UserController::login_here');

$routes->match(['get', 'post'], '/Cart', 'Home::Cart', ['filter'=>'userauth']);
$routes->match(['get', 'post'], '/updatecart', 'Home::updatecart', ['filter'=>'userauth']);
$routes->post('buy/saveCardDetails', 'Home::saveCardDetails', ['filter'=>'userauth']);
$routes->post('buy/upi_submit', 'Home::upi_submit', ['filter'=>'userauth']);

$routes->match(['get', 'post'], '/addtocart', 'Home::addtocart', ['filter'=>'userauth']);

$routes->match(['get', 'post'], '/Profile', 'Home::Profile', ['filter'=>'userauth']);
$routes->match(['get', 'post'], '/editaddress', 'Home::editaddress', ['filter'=>'userauth']);
$routes->match(['get', 'post'], '/getAddress/(:any)', 'Home::getAddress/$1', ['filter'=>'userauth']);
$routes->match(['get', 'post'], '/uploadimage', 'Home::uploadimage', ['filter'=>'userauth']);
$routes->match(['get', 'post'], '/editprofile', 'Home::editprofile', ['filter'=>'userauth']);

$routes->match(['get', 'post'], '/Profile/returnitem/(:any)', 'Home::returnitem/$1', ['filter'=>'userauth']);
$routes->match(['get', 'post'], 'Profile/getorders/(:any)', 'Home::getorders/$1', ['filter'=>'userauth']);
$routes->match(['get', 'post'], 'Profile/getcustomer/(:any)', 'Home::getcustomer/$1', ['filter'=>'userauth']);
$routes->match(['get', 'post'], 'Profile/getproduct/(:any)', 'Home::getproduct/$1', ['filter'=>'userauth']);
$routes->match(['get', 'post'], 'Profile/getbuyproducts/(:any)/(:any)', 'Home::getbuyproducts/$1/$2', ['filter'=>'userauth']);

$routes->get('/logout', 'UserController::logout');
$routes->get('/deleteData/(:any)/(:any)/(:any)', 'Home::deleteData/$1/$2/$3',['filter'=>'userauth']);
$routes->match(['get', 'post'], '/buy/(:any)/(:any)/(:any)', 'Home::buy/$1/$2/$3',['filter'=>'userauth']);
$routes->match(['get', 'post'], '/placeorder/(:any)', 'Home::placeorder/$1',['filter'=>'userauth']);
$routes->match(['get', 'post'], '/changestate', 'Home::changestate', ['filter'=>'userauth']);





$routes->get('/admin', 'Admin::index');
$routes->match(['get','post'],'/login', 'Login::index');
$routes->get('/admin/logout', 'Login::logout');

$routes->get('/admin/dashboard', 'Admin::dashboard',['filter'=>'auth']);

$routes->get('/admin/useraccounts', 'Admin::useraccounts',['filter'=>'auth']);
$routes->get('/admin/staff', 'Admin::staff',['filter'=>'auth']);
$routes->get('/admin/subscribers', 'Admin::subscribers',['filter'=>'auth']);
$routes->get('/admin/messages', 'Admin::messages',['filter'=>'auth']);
$routes->match(['get','post'],'admin/setting', 'Admin::setting',['filter'=>'auth']);

$routes->get('/admin/deleteData/(:any)/(:any)/(:any)', 'Admin::deleteData/$1/$2/$3',['filter'=>'auth']);
$routes->match(['get', 'post'], '/admin/changestate', 'Admin::changestate', ['filter'=>'auth']);

$routes->get('/admin/returned_orders', 'Admin::returned_orders',['filter'=>'auth']);
$routes->get('/admin/order', 'Admin::order',['filter'=>'auth']);

$routes->match(['get', 'post'], '/getorders/(:any)', 'Admin::getorders/$1', ['filter'=>'auth']);
$routes->match(['get', 'post'], '/getcustomer/(:any)', 'Admin::getcustomer/$1', ['filter'=>'auth']);
$routes->match(['get', 'post'], '/getproduct/(:any)', 'Admin::getproduct/$1', ['filter'=>'auth']);
$routes->match(['get', 'post'], '/getbuyproducts/(:any)/(:any)', 'Admin::getbuyproducts/$1/$2', ['filter'=>'auth']);

$routes->get('/admin/product', 'Admin::product',['filter'=>'auth']);
$routes->match(['get','post'],'/admin/addproduct', 'Admin::addproduct',['filter'=>'auth']);
$routes->match(['get','post'],'admin/edit_product/(:any)', 'Admin::edit_product/$1',['filter'=>'auth']);


$routes->match(['get', 'post'], 'admin/staffdetails/(:any)', 'Admin::staffdetails/$1', ['filter'=>'auth']);
$routes->match(['get', 'post'], 'admin/staffedit/(:any)', 'Admin::staffedit/$1', ['filter'=>'auth']);
$routes->match(['get', 'post'], 'admin/staffadd', 'Admin::staffadd', ['filter'=>'auth']);
$routes->match(['get', 'post'], '/admin/markattendance', 'Admin::markattendance', ['filter'=>'auth']);
$routes->get('/admin/deleteDocu/(:any)/(:any)/(:any)', 'Admin::deleteDocu/$1/$2/$3',['filter'=>'auth']);

$routes->match(['get', 'post'], '/getstaff/(:any)', 'Admin::getstaff/$1', ['filter'=>'auth']);

$routes->match(['get', 'post'], 'admin/staffcard/(:any)', 'Admin::staffcard/$1', ['filter'=>'auth']);

$routes->match(['get', 'post'], 'admin/invoice/(:any)', 'invoice::index/$1', ['filter'=>'auth']);

$routes->match(['get','post'],'staff', 'Staff::index');
$routes->get('/staff/logout', 'staff::logout');
$routes->get('/staff/dashboard', 'staff::dashboard',['filter'=>'staffauth']);
$routes->match(['get', 'post'], '/staff/changestate', 'staff::changestate', ['filter'=>'auth']);