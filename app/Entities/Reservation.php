<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Reservation extends Entity
{   
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'          => '?integer',
        'area_id'     => '?integer',
        'resident_id' => '?integer',
    ];
}
