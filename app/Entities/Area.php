<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Area extends Entity
{    
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id' => '?integer',
    ];
}
