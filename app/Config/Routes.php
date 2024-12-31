<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'Home::login');
$routes->post('/loginuser','Home::loginuser');
$routes->get('/logout', 'Home::logout');


$routes->get('/', 'Home::index');

// users
$routes->get('/users','Home::userpage');

$routes->get('/createuserpage','Home::createuserpage');
$routes->post('/adduser', 'Home::adduser');

$routes->get('/edit/(:any)', 'Home::editpage/$1');
$routes->post('/updateuser/(:any)', 'Home::updateuser/$1');

$routes->get('/delete/(:any)', 'Home::delete/$1');

// campaigns
$routes->get('/campaign','Campaign::index');
$routes->get('/createcampaignpage','Campaign::createcampaign');
$routes->post('/addcampaign','Campaign::addcampaign');
$routes->get('/geteditcampaign/(:any)','Campaign::geteditcampaign/$1');
$routes->post('/editcampaign/(:any)','Campaign::editcampaign/$1');
$routes->get('/deletecampaign/(:any)','Campaign::deletecampaign/$1');
