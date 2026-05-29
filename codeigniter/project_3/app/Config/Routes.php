<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');

// Auth
$routes->get('auth/login', 'AuthController::login');
$routes->post('auth/login', 'AuthController::login');
$routes->get('auth/register', 'AuthController::register');
$routes->post('auth/register', 'AuthController::register');
$routes->get('auth/logout', 'AuthController::logout');

// Berita (public)
$routes->get('berita', 'Post::index');
$routes->get('berita/(:any)', 'Post::viewPost/$1');

// Project (public)
$routes->get('project', 'ProjectController::index');
$routes->get('project/mine', 'ProjectController::myProjects', ['filter' => 'mahasiswa']);
$routes->match(['get','post'], 'project/submit', 'ProjectController::submit', ['filter' => 'mahasiswa']);
$routes->get('project/(:any)', 'ProjectController::detail/$1');

// Admin — berita
$routes->group('admin', ['filter' => 'admin'], static function($routes) {
    $routes->get('dashboard', 'AdminDashboard::index');
    $routes->get('/', 'AdminDashboard::index');
    
    $routes->get('post', 'PostAdmin::index');
    $routes->get('post/(:segment)/preview', 'PostAdmin::preview/$1');
    $routes->match(['get','post'], 'post/new', 'PostAdmin::create');
    $routes->match(['get','post'], 'post/(:segment)/edit', 'PostAdmin::edit/$1');
    $routes->get('post/(:segment)/delete', 'PostAdmin::delete/$1');

    // Admin — project
    $routes->get('project', 'ProjectAdminController::index');
    $routes->get('project/(:segment)/approve', 'ProjectAdminController::approve/$1');
    $routes->get('project/(:segment)/reject', 'ProjectAdminController::reject/$1');
    $routes->get('project/(:segment)/delete', 'ProjectAdminController::delete/$1');
});
