<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Notification extends Entity
{
    protected $dates   = ['created_at'];
    protected $casts   = [
        'id' => 'integer',
    ];
}
