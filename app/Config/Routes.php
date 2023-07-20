<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// 'localhost:8080'로 넘어 왔을때
$routes->get('/', 'Home::index');

# Blog
// Create
$routes->match(['get', 'post'], 'blog/create', 'BlogController::create', ['filter' => 'auth']);
// Index
$routes->get('blog', 'BlogController::index');
// View
$routes->get('blog/(:segment)', 'BlogController::view/$1');
// Update
$routes->match(['get', 'post'], 'blog/update/(:segment)', 'BlogController::update/$1', ['filter' => 'auth']);
// Delete
$routes->match(['get', 'post'], 'blog/delete/(:segment)', 'BlogController::delete/$1', ['filter' => 'auth']);

# User
// 회원가입 (필터 - 로그인 여부 체크)
$routes->match(['get', 'post'], 'register', 'UserController::register', ['filter' => 'noauth']);
// 로그인 (필터 - 로그인 여부 체크)
$routes->match(['get', 'post'], 'login', 'UserController::login', ['filter' => 'noauth']);
// 로그아웃
$routes->get('logout', 'UserController::logout');
// 프로필 (필터 - 로그인 여부 체크)
$routes->get('profile', 'UserController::profile', ['filter' => 'auth']);
// 정보수정 (필터 - 로그인 여부 체크)
$routes->match(['get', 'post'], 'user_update', 'UserController::user_update', ['filter' => 'auth']);

# News Section (아래 Pages 보다 위에 위치 해야 됨. 이유 모름)
// create
$routes->match(['get', 'post'], 'news/create', 'News::create');

// 'localhost:8080/news/xxxxx'로 넘어 왔을때
$routes->get('news/(:segment)', 'News::view/$1');
// 'localhost:8080/news'로 넘어 왔을때
$routes->get('news', 'News::index');

# Pages 
// 'localhost:8080/pages'로 넘어 왔을때
$routes->get('pages', 'Pages::index'); 
// 'localhost:8080/home or about'로 넘어 왔을때
$routes->get('(:segment)', 'Pages::view/$1');

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
