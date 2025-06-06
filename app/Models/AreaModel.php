<?php

namespace App\Models;

use App\Entities\Area;
use App\Models\Basic\AppModel;


class AreaModel  extends AppModel
{
    protected $table            = 'areas';        
    protected $returnType       = Area::class;    
    protected $allowedFields    = [        
        'name',
        'description',
        'code',        
    ];      

    protected function relateData(object &$area, array $contains = []): void
    {
        if(in_array('reservations', $contains)) {
           //TODO: Recuperar as reservas que cada área possui.
        }
    }
}
