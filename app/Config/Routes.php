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
$routes->setTranslateURIDashes(false);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//users
$routes->get('/users/','UsersController::showHome');
$routes->get('/users/login','UsersController::showLoginForm');
$routes->get('/users/register','UsersController::showRegisterForm');
$routes->post('/users/register','UsersController::Register');
$routes->post('/users/login','UsersController::Login');
$routes->get('/users/logoff','UsersController::Logoff');

//transfers
$routes->post('/transfers','TransfersController::createTransfer');
$routes->post('/transfers/payment','TransfersController::createPayment');
$routes->post('/transfers/require','TransfersController::requireMoney');
//transfers/saving/
$routes->post('/transfers/saving/rescue','TransfersController::rescueFromSavingAccount');
$routes->post('/transfers/saving/apply','TransfersController::ApplyToSavingAccount');

//Not Found redirect to /users
$routes->get('(:any)','HomeController::index');

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
