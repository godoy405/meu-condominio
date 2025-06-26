<?php

namespace App\Entities;

use App\Traits\Entities\ResidentFilterTrait;
use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Visit extends Entity
{    
    use ResidentFilterTrait;
    
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'          => '?integer',
        'resident_id' => '?integer',
        'is_used'     => 'boolean'
    ];

    public function isValid(): bool
    {
        return !$this->is_used && $this->valid_until >= Time::now()->format('Y-m-d H:i:s');
    }

    public function used(): string
    {
        return $this->is_used ? 'Sim' : 'Não';
    }

    public function usedIn(): string
    {
        return $this->is_used ? $this->used_in : 'Não se aplica';
    }
}
