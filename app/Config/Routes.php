<?php

use App\Controllers\HomeController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\ResidentsController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home']);

service('auth')->routes($routes);

$routes->group('residents', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [ResidentsController::class, 'index'], ['as' => 'residents']);
    $routes->get('new', [ResidentsController::class, 'new'], ['as' => 'residents.new']);
    $routes->post('create', [ResidentsController::class, 'create'], ['as' => 'residents.create']);
    $routes->get('show/(:segment)', [ResidentsController::class, 'show/$1'], ['as' => 'residents.show']);
    $routes->get('edit/(:segment)', [ResidentsController::class, 'edit/$1'], ['as' => 'residents.edit']);
    $routes->put('update/(:segment)', [ResidentsController::class, 'update/$1'], ['as' => 'residents.update']);
    $routes->delete('destroy/(:segment)', [ResidentsController::class, 'destroy/$1'], ['as' => 'residents.destroy']);

    // rotas para gerenciamento do user do residente

    $routes->group('user', static function ($routes) {
        $routes->get('(:segment)', [ResidentUserController::class, 'index'], ['as' => 'residents.user']);       
        $routes->post('create/(:segment)', [ResidentUserController::class, 'create/$1'], ['as' => 'residents.user.create']);       
        $routes->put('update/(:segment)', [ResidentUserController::class, 'update/$1'], ['as' => 'residents.user.update']);   
        $routes->put('action/(:segment)', [ResidentUserController::class, 'action/$1'], ['as' => 'residents.user.action']);     
    });
});
