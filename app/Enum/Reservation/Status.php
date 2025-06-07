<?php

namespace App\Enum\Reservation;

enum Status : string {
    case PENDING   = 'PENDING';
    case APPROVED  = 'APPROVED';
    case REJECTED  = 'REJECTED';
    case CANCELED  = 'CANCELED';
    case COMPLETED = 'COMPLETED';
    
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendente, aguardando revisão do síndico',
            self::APPROVED => 'Aprovado',
            self::REJECTED => 'Rejeitado pelo residente',
            self::CANCELED => 'Cancelado pelo síndico',
            self::COMPLETED => 'Concluída. Reserva finalizada',
        };
    }
}