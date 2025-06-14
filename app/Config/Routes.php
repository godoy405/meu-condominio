<?php

use App\Controllers\HomeController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\AreasController;
use App\Controllers\ResidentUserController;
use App\Controllers\ReservationsController;
use App\Controllers\ReservationsBillsController; // Adicione esta linha

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


//! Sem filtro global
$routes->group('reservations', static function ($routes) {
    $routes->get('/', [ReservationsController::class, 'index'], ['as' => 'reservations']);
    $routes->get('new', [ReservationsController::class, 'new'], ['as' => 'reservations.new', 'filter' => 'group:user']);
    $routes->post('create', [ReservationsController::class, 'create'], ['as' => 'reservations.create']);
    $routes->get('show/(:segment)', [ReservationsController::class, 'show/$1'], ['as' => 'reservations.show']);    
    $routes->put('cancel/(:segment)', [ReservationsController::class, 'cancel/$1'], ['as' => 'reservations.cancel', 'filter' => 'group:user']);

    
    // rotas das cobranças das reservas
    $routes->group('bills', ['filter' => 'group:superadmin,admin'], static function ($routes) { // Adicionado grupo admin
        $routes->get('(:segment)', [ReservationsBillsController::class, 'index/$1'], ['as' => 'reservations.bills']);        
        $routes->post('create', [ReservationsBillsController::class, 'create'], ['as' => 'reservations.bills.create']);           
        $routes->put('update/(:segment)', [ReservationsBillsController::class, 'update/$1'], ['as' => 'reservations.bills.update']);
    });
  
});



