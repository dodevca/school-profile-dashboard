<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/',                               'Home::index');
$routes->match(['get', 'post'], 'login',        'Auth::index');
$routes->get('logout',                          'Auth::logout');
$routes->get('profil',                          'Profile::index');
$routes->post('profil/password',                'Profile::password');
$routes->post('profil/username',                'Profile::username');
$routes->get('berita',                          'News::index');
$routes->get('berita/tambah',                   'News::add');
$routes->get('berita/(:num)',                   'News::edit/$1');
$routes->post('berita/create',                  'News::create');
$routes->post('berita/update',                  'News::update');
$routes->get('berita/(:num)/delete',            'News::delete/$1');
$routes->get('pengumuman',                      'Announcement::index');
$routes->get('pengumuman/tambah',               'Announcement::add');
$routes->get('pengumuman/(:num)',               'Announcement::edit/$1');
$routes->post('pengumuman/create',              'Announcement::create');
$routes->post('pengumuman/update',              'Announcement::update');
$routes->get('pengumuman/(:num)/delete',        'Announcement::delete/$1');
$routes->get('agenda',                          'Event::index');
$routes->get('agenda/tambah',                   'Event::add');
$routes->get('agenda/(:num)',                   'Event::edit/$1');
$routes->post('agenda/create',                  'Event::create');
$routes->post('agenda/update',                  'Event::update');
$routes->get('agenda/(:num)/delete',            'Event::delete/$1');
$routes->get('pengajuan-agenda',                'Maintenance::index');
$routes->get('galeri',                          'Gallery::index');
$routes->get('galeri/tambah',                   'Gallery::add');
$routes->get('galeri/(:num)',                   'Gallery::edit/$1');
$routes->post('galeri/upload-image',            'Gallery::upload');
$routes->post('galeri/create',                  'Gallery::create');
$routes->post('galeri/update',                  'Gallery::update');
$routes->get('galeri/(:num)/delete',            'Gallery::delete/$1');
$routes->get('modul',                           'Modul::index');
$routes->get('modul/tambah',                    'Modul::add');
$routes->get('modul/(:hash)',                   'Modul::edit/$1');
$routes->post('modul/create',                   'Modul::create');
$routes->post('modul/update',                   'Modul::update');
$routes->get('modul/(:hash)/delete',            'Modul::delete/$1');
$routes->get('prestasi',                        'Achievement::index');
$routes->get('prestasi/tambah',                 'Achievement::add');
$routes->get('prestasi/(:num)',                 'Achievement::edit/$1');
$routes->post('prestasi/create',                'Achievement::create');
$routes->post('prestasi/update',                'Achievement::update');
$routes->get('prestasi/(:hash)/delete',         'Achievement::delete/$1');
$routes->get('ikatan-alumni',                   'Maintenance::index');
$routes->get('ikatan-alumni/1234567890',        'Maintenance::edit');
$routes->get('pengajuan-data-alumni',           'Maintenance::index');
$routes->get('uploads/(:hash)/delete',          'Upload::index/$1');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
