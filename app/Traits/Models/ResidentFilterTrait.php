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
           $this->where("{$this->table}.resident_id", auth()->user()->resident->id ?? null);
        }

        return $this;
    }

}