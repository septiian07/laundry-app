<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

// Set default controller to Dashboard
$routes->setDefaultController('Dashboard');
$routes->get('/', 'Dashboard::index');

// Routes for Customers (CRUD)
$routes->get('customers', 'Customers::index');
$routes->get('customers/create', 'Customers::create');
$routes->post('customers/save', 'Customers::save');
$routes->get('customers/edit/(:num)', 'Customers::edit/$1');
$routes->put('customers/update/(:num)', 'Customers::update/$1');
$routes->post('customers/update/(:num)', 'Customers::update/$1');
$routes->delete('customers/delete/(:num)', 'Customers::delete/$1');
$routes->post('customers/delete/(:num)', 'Customers::delete/$1');

// Routes for Services (CRUD)
$routes->get('services', 'Services::index');
$routes->get('services/create', 'Services::create');
$routes->post('services/save', 'Services::save');
$routes->get('services/edit/(:num)', 'Services::edit/$1');
$routes->put('services/update/(:num)', 'Services::update/$1');
$routes->post('services/update/(:num)', 'Services::update/$1');
$routes->delete('services/delete/(:num)', 'Services::delete/$1');
$routes->post('services/delete/(:num)', 'Services::delete/$1');

// Routes for Transactions
$routes->get('transactions', 'Transactions::index');
$routes->get('transactions/create', 'Transactions::create');
$routes->post('transactions/save', 'Transactions::save');
$routes->get('transactions/show/(:num)', 'Transactions::show/$1');
$routes->post('transactions/updateStatus/(:num)', 'Transactions::updateStatus/$1');
$routes->delete('transactions/delete/(:num)', 'Transactions::delete/$1');
$routes->post('transactions/delete/(:num)', 'Transactions::delete/$1');
$routes->get('transactions/printReceipt/(:num)', 'Transactions::printReceipt/$1');

$routes->get('dashboard', 'Dashboard::index');
