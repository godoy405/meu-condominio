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
        'due_date'       => 'datetime', // Alterado de '?date' para 'datetime'
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

    public function amount(): string 
    {
       return show_price($this->attributes['amount']);
    }

    public function status(): string 
    {
       return $this->isPaid() ? 'Pago' : 'Pendente';
    }


    public function setDueDate($date): self
    {
        if (empty($date)) {
            $this->attributes['due_date'] = null;
        } else if (is_string($date)) {
            try {
                $this->attributes['due_date'] = new \DateTime($date);
                // Log para depuração
                log_message('debug', 'setDueDate de string: ' . $date . ' para ' . print_r($this->attributes['due_date'], true));
            } catch (\Exception $e) {
                log_message('error', 'Erro ao converter data: ' . $e->getMessage());
                $this->attributes['due_date'] = null;
            }
        } else if ($date instanceof \DateTime) {
            $this->attributes['due_date'] = $date;
            // Log para depuração
            log_message('debug', 'setDueDate de DateTime: ' . print_r($this->attributes['due_date'], true));
        } else {
            // Já é um objeto DateTime ou Time ou outro tipo
            $this->attributes['due_date'] = $date;
            // Log para depuração
            log_message('debug', 'setDueDate de outro tipo: ' . gettype($date) . ' para ' . print_r($this->attributes['due_date'], true));
        }
        return $this;
    }

    public function dueDate(): string 
    {
        if (empty($this->attributes['due_date'])) {
            return '';
        }
        
        if ($this->attributes['due_date'] instanceof \DateTime) {
            return $this->attributes['due_date']->format('d/m/Y');
        }
        
        if (is_string($this->attributes['due_date'])) {
            try {
                $date = new \DateTime($this->attributes['due_date']);
                return $date->format('d/m/Y');
            } catch (\Exception $e) {
                log_message('error', 'Erro ao formatar data: ' . $e->getMessage());
                return $this->attributes['due_date'];
            }
        }
        
        // Para outros casos, tenta converter para string
        return (string) $this->attributes['due_date'];
    }



    public function setCode(int $code): self {
        $this->attributes['code'] = $code;
        return $this;
    }
        
    
    public function notes(): string
    {
        return $this->attributes['notes'] ?? '';
    }
}