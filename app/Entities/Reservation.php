<?php

namespace App\Entities;

use App\Enum\Reservation\Status;
use App\Traits\Models\ResidentFilterTrait;
use CodeIgniter\Entity\Entity;

class Reservation extends Entity
{   

    use ResidentFilterTrait;

    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'          => '?integer',
        'area_id'     => '?integer',
        'resident_id' => '?integer',
    ];

    public function canBeCanceled(): bool
    {
        return $this->status === Status::PENDING->value;
    }

    public function status(): string
    {
        return Status::from($this->status)->label();
    }

}
