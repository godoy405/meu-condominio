<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Traits\Entities\ResidentFilterTrait;

class Announcement extends Entity
{
    use ResidentFilterTrait;
    
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id' => '?integer',
        'resident_id' => '?integer',
        'code' => '?string',
        'is_public' => '?boolean',
    ];

    public function author(): string {
        return $this->is_public ? $this?->resident?->name ?? '' : 'Anônimo';
    }
}
