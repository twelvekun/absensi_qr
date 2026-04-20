<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/process', 'Auth::process');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/kelas', 'Kelas::index');
$routes->get('/kelas/create', 'Kelas::create'); 
$routes->post('/kelas/store', 'Kelas::store');
$routes->get('/kelas/show/(:num)', 'Kelas::show/$1');
$routes->get('/kelas/edit/(:num)', 'Kelas::edit/$1');
$routes->post('/kelas/update/(:num)', 'Kelas::update/$1'); 
$routes->get('/kelas/delete/(:num)', 'Kelas::delete/$1');
$routes->get('/siswa', 'Siswa::index');
$routes->get('/siswa/create', 'Siswa::create'); 
$routes->post('/siswa/store', 'Siswa::store');
$routes->get('/siswa/show/(:num)', 'Siswa::show/$1');
$routes->get('/siswa/edit/(:num)', 'Siswa::edit/$1');
$routes->post('/siswa/update/(:num)', 'Siswa::update/$1');
$routes->get('/siswa/delete/(:num)', 'Siswa::delete/$1');
$routes->get('/guru', 'Guru::index');
$routes->get('/guru/create', 'Guru::create');
$routes->post('/guru/store', 'Guru::store');
$routes->get('/guru/show/(:num)', 'Guru::show/$1');
$routes->get('/guru/edit/(:num)', 'Guru::edit/$1');
$routes->post('/guru/update/(:num)', 'Guru::update/$1');
$routes->get('/guru/delete/(:num)', 'Guru::delete/$1');
$routes->get('/staf', 'Staf::index');
$routes->get('/staf/create', 'Staf::create');
$routes->post('/staf/store', 'Staf::store');
$routes->get('/staf/show/(:num)', 'Staf::show/$1');
$routes->get('/staf/edit/(:num)', 'Staf::edit/$1');
$routes->post('/staf/update/(:num)', 'Staf::update/$1');
$routes->get('/staf/delete/(:num)', 'Staf::delete/$1');
$routes->get('/scan', 'Absensi::scan');
$routes->post('/absensi/proses_scan', 'Absensi::proses_scan');
$routes->get('/laporan/siswa', 'Laporan::siswa');
$routes->get('/laporan/guru', 'Laporan::guru');
$routes->get('/generateqr', 'GenerateQr::index');
$routes->get('/generateqr/show/(:any)/(:num)', 'GenerateQr::show/$1/$2');