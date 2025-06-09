<?php

namespace App\Traits\Models;

trait ResidentFilterTrait
{

    /**
     * Adiciona uma condição de `where`par filtrar registos pelo residente logado
     *
     * 
     * @return self
     */

    public function whereResident(): self
    {
        if(auth()->user()->inGroup('user')) {
            $residentId = auth()->user()->resident_id ?? null;
            if ($residentId) {
                $this->where("{$this->table}.resident_id", $residentId);
            } else {
                // Se não há residente associado, não retorna nenhum registro
                $this->where("{$this->table}.resident_id", -1);
            }
        }

        return $this;
    }

}