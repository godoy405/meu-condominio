<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Bill extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'due_date'];
    protected $casts   = [
        'id'             => '?integer',
        'reservation_id' => '?integer',
        'resident_id'    => '?integer',
        'code'           => '?string',
        'due_date'       => '?date',
        'status'         => '?string',
        'amount'         => '?float',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function setResidentId(int|string $residentId): self 
    {
        $this->attributes['resident_id'] = empty($residentId) ? null : intval($residentId);
        return $this;
    }

    public function setAmount(string $amount): self 
    {
        $amount = preg_replace('/\D/', '', $amount);
        $this->attributes['amount'] = intval($amount);
        return $this;
    }

    public function amount(string $amount): string 
    {
       return show_price($this->attributes['amount']);
    }

    public function status(): string 
    {
       return $this->isPaid() ? 'Pago' : 'Pendente';
    }


    public function dueDate(): string 
    {
       return $this->attributes['due_date']->format('d/m/Y');
    }



    public function setCode(int $code): self {
        $this->attributes['code'] = $code;
        return $this;
    }
        
    
}