<?php

namespace App\Enum\Occurrence;

enum Status: string
{
    case Open     = 'open';
    case Progress = 'in_progress';
    case Closed   = 'closed';
     

    public function label(): string
    {
        return match ($this) {
            self::Open     => 'Em aberto',
            self::Progress => 'Em andamento',
            self::Closed   => 'Resolvida',            
        };
    }

}