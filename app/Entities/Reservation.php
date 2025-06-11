<?php

namespace App\Entities;

use App\Enum\Reservation\Status;
use App\Traits\Entities\ResidentFilterTrait;
use CodeIgniter\Entity\Entity;

class Reservation extends Entity
{
   
    use ResidentFilterTrait;

    protected $dates   = ['created_at', 'updated_at', 'desired_date'];
    protected $casts   = [
        'id'            => '?integer',
        'area_id'       => '?integer',  
        'resident_id'   => '?integer',              
    ];

    // Campos calculados
    protected $datamap = [
        'area_name' => 'area_name',
        'email' => 'resident_email'
    ];
 
    public function canBeCanceled(): bool
    {
        // Remova a verificação de ->value e simplifique
        log_message('debug', 'Status atual na verificação canBeCanceled: ' . $this->status);
        log_message('debug', 'Status::PENDING: ' . Status::PENDING);
        
        // Forçar retorno true para teste
        return true; // Temporariamente retorne true para testar o fluxo
        
        // Depois que funcionar, você pode voltar para a verificação normal:
        // return $this->status === Status::PENDING;
    }

    public function status(): string
    {
        // Use um mapeamento manual em vez de Status::from()->label()
        $labels = [
            Status::PENDING => 'Pendente',
            Status::CONFIRMED => 'Confirmada',
            Status::CANCELLED => 'Cancelada',
            Status::COMPLETED => 'Concluída'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }

    // Método para obter o email do residente
    public function getResidentEmail()
    {
        if (isset($this->attributes['resident_email'])) {
            return $this->attributes['resident_email'];
        }

        if (isset($this->resident) && isset($this->resident->email)) {
            return $this->resident->email;
        }

        return null;
    }
}