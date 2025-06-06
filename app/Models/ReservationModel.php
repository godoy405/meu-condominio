<?php

namespace App\Models;

use App\Entities\Reservation;
use App\Models\Basic\AppModel;


class ReservationModel  extends AppModel
{
    protected $table            = 'reservations';        
    protected $returnType       = Reservation::class;   
    protected $allowedFields    = [        
        'area_id',
        'resident_id',
        'notes',        
        'status'
        'reason_status'
        'desired_date',
    ];      

    protected function relateData(object &$area, array $contains = []): void
    {
        if(in_array('reservations', $contains)) {
           //TODO: Recuperar as reservas que cada área possui.
        }
    }
}
