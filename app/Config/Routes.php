<?php

use App\Controllers\HomeController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\AreasController;
use App\Controllers\NotificationsController;
use App\Controllers\ResidentsController; // Adicionando a importação do controlador
use App\Controllers\ResidentUserController;
use App\Controllers\ReservationsController;
use App\Controllers\ReservationsBillsController;
use App\Controllers\AnnouncementsController; // Adicionando a importação do controlador de anúncios
use App\Controllers\AnnouncementCommentsController; // Adicionando a importação do controlador de comentários
use App\Controllers\BillsController;
use App\Controllers\OccurrenceResolveController;
use App\Controllers\OccurrencesController;
use App\Entities\Announcement;
use App\Entities\Occurrence;
use App\Controllers\OccurrenceUpdatesController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home']);

service('auth')->routes($routes);

$routes->group('residents', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [ResidentsController::class, 'index'], ['as' => 'residents']);
    $routes->get('new', [ResidentsController::class, 'new'], ['as' => 'residents.new']);
    $routes->post('create', [ResidentsController::class, 'create'], ['as' => 'residents.create']);
    $routes->get('show/(:segment)', [ResidentsController::class, 'show'], ['as' => 'residents.show']); // Corrigido
    $routes->get('edit/(:segment)', [ResidentsController::class, 'edit'], ['as' => 'residents.edit']); // Corrigido
    $routes->put('update/(:segment)', [ResidentsController::class, 'update'], ['as' => 'residents.update']); // Corrigido
    $routes->delete('destroy/(:segment)', [ResidentsController::class, 'destroy'], ['as' => 'residents.destroy']); // Corrigido

    // rotas para gerenciamento do user do residente
    $routes->group('user', static function ($routes) {
        $routes->get('(:segment)', [ResidentUserController::class, 'index'], ['as' => 'residents.user']);       
        $routes->post('create/(:segment)', [ResidentUserController::class, 'create'], ['as' => 'residents.user.create']);       
        $routes->put('update/(:segment)', [ResidentUserController::class, 'update'], ['as' => 'residents.user.update']);   
        $routes->put('action/(:segment)', [ResidentUserController::class, 'action'], ['as' => 'residents.user.action']);     
    });
});



$routes->group('areas', ['filter' => 'group:superadmin'], static function ($routes) {
    $routes->get('/', [AreasController::class, 'index'], ['as' => 'areas']);
    $routes->get('new', [AreasController::class, 'new'], ['as' => 'areas.new']);
    $routes->post('create', [AreasController::class, 'create'], ['as' => 'areas.create']);
    $routes->get('show/(:segment)', [AreasController::class, 'show'], ['as' => 'areas.show']);
    $routes->get('edit/(:segment)', [AreasController::class, 'edit'], ['as' => 'areas.edit']);
    $routes->put('update/(:segment)', [AreasController::class, 'update'], ['as' => 'areas.update']);
    $routes->delete('destroy/(:segment)', [AreasController::class, 'destroy'], ['as' => 'areas.destroy']);
  
});
//! Sem filtro global
$routes->group('reservations', static function ($routes) {
    $routes->get('/', [ReservationsController::class, 'index'], ['as' => 'reservations']);
    $routes->get('new', [ReservationsController::class, 'new'], ['as' => 'reservations.new', 'filter' => 'group:user']);
    $routes->post('create', [ReservationsController::class, 'create'], ['as' => 'reservations.create']);
    $routes->get('show/(:segment)', [ReservationsController::class, 'show'], ['as' => 'reservations.show']);    
    $routes->put('cancel/(:segment)', [ReservationsController::class, 'cancel'], ['as' => 'reservations.cancel', 'filter' => 'group:user']);

    
    // rotas das cobranças das reservas
    $routes->group('bills', ['filter' => 'group:superadmin'], static function ($routes) { // Adicionado grupo admin
        $routes->get('(:segment)', [ReservationsBillsController::class, 'index'], ['as' => 'reservations.bills']);        
        $routes->post('create/(:segment)', [ReservationsBillsController::class, 'create'], ['as' => 'reservations.bills.create']);           
        $routes->put('update/(:segment)', [ReservationsBillsController::class, 'update'], ['as' => 'reservations.bills.update']);
    });
});

$routes->group('notifications', static function ($routes) {
    $routes->get('/', [NotificationsController::class, 'index'], ['as' => 'notifications']);
    $routes->get('new', [NotificationsController::class, 'new'], ['as' => 'notifications.new', 'filter' => 'group:user']);
    $routes->get('show/(:segment)', [NotificationsController::class,'show'], ['as' => 'notifications.show']);
    $routes->post('create', [NotificationsController::class, 'create'], ['as' => 'notifications.create']);        
    $routes->delete('destroy/(:segment)', [NotificationsController::class, 'destroy'], ['as' => 'notifications.destroy']);
});

$routes->group('announcements', static function ($routes) {
    $routes->get('/', [AnnouncementsController::class, 'index'], ['as' => 'announcements']);
    $routes->get('new', [AnnouncementsController::class, 'new'], ['as' => 'announcements.new']);
    $routes->get('show/(:segment)', [AnnouncementsController::class, 'show'], ['as' => 'announcements.show']);
    $routes->post('create', [AnnouncementsController::class, 'create'], ['as' => 'announcements.create']);    
    $routes->delete('destroy/(:segment)', [AnnouncementsController::class, 'destroy'], ['as' => 'announcements.destroy']);

    $routes->group('comments', static function ($routes) {     
        $routes->post('create/(:segment)', [AnnouncementCommentsController::class, 'create'], ['as' => 'announcements.comments.create']);      
    });
});

$routes->group('bills', static function ($routes) {
    $routes->get('/', [BillsController::class, 'index'], ['as' => 'bills']);
    $routes->get('new', [BillsController::class, 'new'], ['as' => 'bills.new', 'filter' => 'group:superadmin']);
    $routes->post('create', [BillsController::class, 'create'], ['as' => 'bills.create']);
    $routes->get('show/(:segment)', [BillsController::class, 'show'], ['as' => 'bills.show']);
    $routes->get('edit/(:segment)', [BillsController::class, 'edit'], ['as' => 'bills.edit', 'filter' => 'group:superadmin']);
    $routes->put('update/(:segment)', [BillsController::class, 'update'], ['as' => 'bills.update']);
    $routes->delete('destroy/(:segment)', [BillsController::class, 'destroy'], ['as' => 'bills.destroy', 'filter' => 'group:superadmin']);
  
});

$routes->group('occurrences', static function ($routes) {
    $routes->get('/', [OccurrencesController::class, 'index'], ['as' => 'occurrences']);
    $routes->get('new', [OccurrencesController::class, 'new'], ['as' => 'occurrences.new', 'filter' => 'group:user']);
    $routes->post('create', [OccurrencesController::class, 'create'], ['as' => 'occurrences.create']);
    $routes->get('show/(:segment)', [OccurrencesController::class, 'show'], ['as' => 'occurrences.show']);  
    
    $routes->group('updates', static function ($routes) {     
        $routes->post('create/(:segment)', [OccurrenceUpdatesController::class, 'create'], ['as' => 'occurrences.updates.create']);      
    });

    $routes->group('resolve', ['filter' => 'group:superadmin'],static function ($routes) {   
        $routes->get('(:segment)', [OccurrenceResolveController::class, 'index'], ['as' => 'occurrences.resolve']);  
        $routes->post('process/(:segment)', [OccurrenceResolveController::class, 'process'], ['as' => 'occurrences.resolve.process']);             
    });
  
});




