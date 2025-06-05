<?php

use App\Controllers\HomeController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\AreasController;
use App\Controllers\ResidentUserController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home']);

service('auth')->routes($routes);

$routes->group('areas', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [AreasController::class, 'index'], ['as' => 'areas']);
    $routes->get('new', [AreasController::class, 'new'], ['as' => 'areas.new']);
    $routes->post('create', [AreasController::class, 'create'], ['as' => 'areas.create']);
    $routes->get('show/(:segment)', [AreasController::class, 'show/$1'], ['as' => 'areas.show']);
    $routes->get('edit/(:segment)', [AreasController::class, 'edit/$1'], ['as' => 'areas.edit']);
    $routes->put('update/(:segment)', [AreasController::class, 'update/$1'], ['as' => 'areas.update']);
    $routes->delete('destroy/(:segment)', [AreasController::class, 'destroy/$1'], ['as' => 'areas.destroy']);

    // rotas para gerenciamento do user do residente

    $routes->group('user', static function ($routes) {
        $routes->get('(:segment)', [ResidentUserController::class, 'index'], ['as' => 'areas.user']);       
        $routes->post('create/(:segment)', [ResidentUserController::class, 'create/$1'], ['as' => 'areas.user.create']);       
        $routes->put('update/(:segment)', [ResidentUserController::class, 'update/$1'], ['as' => 'areas.user.update']);   
        $routes->put('action/(:segment)', [ResidentUserController::class, 'action/$1'], ['as' => 'areas.user.action']);     
    });
});

$routes->group('areas', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [AreasController::class, 'index'], ['as' => 'areas']);
    $routes->get('new', [AreasController::class, 'new'], ['as' => 'areas.new']);
    $routes->post('create', [AreasController::class, 'create'], ['as' => 'areas.create']);
    $routes->get('show/(:segment)', [AreasController::class, 'show/$1'], ['as' => 'areas.show']);
    $routes->get('edit/(:segment)', [AreasController::class, 'edit/$1'], ['as' => 'areas.edit']);
    $routes->put('update/(:segment)', [AreasController::class, 'update/$1'], ['as' => 'areas.update']);
    $routes->delete('destroy/(:segment)', [AreasController::class, 'destroy/$1'], ['as' => 'areas.destroy']);

  
});
