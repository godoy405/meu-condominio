<?php

namespace App\Entities;


use App\Enum\Occurrence\Status;
use CodeIgniter\Entity\Entity;

class Occurrence extends Entity
{   
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'          => '?integer',
        'resident_id' => '?integer',
    ];

    public function permitAction():bool
    {
        return auth()->user()->inGroup('superadmin') && $this->status !== Status::Closed->value;
    }

    public function status(): string
    {
        return empty($this->status) ? 'Desconhecido' : Status::tryFrom($this->attributes['status'])->label();
    }

    public function isClosed():bool
    {
        return $this->status === Status::Closed->value;
    }
}
