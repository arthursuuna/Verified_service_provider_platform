<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home route
$routes->get('/', 'Home::index');

// Authentication routes (guest only)
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('auth/login', 'AuthController::processLogin');
    $routes->get('register', 'AuthController::register');
    $routes->post('auth/register', 'AuthController::processRegister');
});

// Logout route (authenticated users only)
$routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);

// User dashboard routes (authenticated regular users)
$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
    $routes->get('profile', 'UserController::profile');
    $routes->post('profile/update', 'UserController::updateProfile');
    $routes->get('requests', 'UserController::requests');
    $routes->get('request/(:num)', 'UserController::viewRequest/$1');
});

// Admin routes (authenticated admin users only)
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('', 'AdminController::dashboard'); // Admin root redirects to dashboard
    $routes->get('providers', 'AdminController::providers');
    $routes->get('provider/(:num)', 'AdminController::viewProvider/$1');
    $routes->get('verify-provider/(:num)', 'AdminController::verifyProvider/$1');
    $routes->get('suspend-provider/(:num)', 'AdminController::suspendProvider/$1');
    $routes->get('users', 'AdminController::users');
    $routes->get('requests', 'AdminController::requests');
    $routes->get('register-admin', 'AuthController::adminRegister');
    $routes->post('auth/register-admin', 'AuthController::processAdminRegister');
});

// Public service provider routes
$routes->get('providers', 'ServiceProviderController::index');
$routes->get('providers/(:segment)', 'ServiceProviderController::category/$1');
$routes->get('provider/(:num)', 'ServiceProviderController::view/$1');
$routes->post('request-service/(:num)', 'ServiceProviderController::requestService/$1');

// Service request routes (authenticated users)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('request-service/(:num)', 'ServiceRequestController::create/$1');
    $routes->post('service-request/submit', 'ServiceRequestController::submit');
    $routes->get('service-requests', 'ServiceRequestController::index');
});

// API routes (for AJAX requests)
$routes->group('api', function ($routes) {
    $routes->get('providers/search', 'Api\ProviderController::search');
    $routes->get('categories', 'Api\CategoryController::index');
});
