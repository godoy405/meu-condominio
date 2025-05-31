<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Resident extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'      => '?integer',
        'user_id' => '?string',
        'code'    => '?string',        
    ];

    /**
     * Indica se o residente tem um usuário associado.
     * @return bool
     */

    public function hasUser(): bool {
        return $this->user_id !== null;
    }
}
