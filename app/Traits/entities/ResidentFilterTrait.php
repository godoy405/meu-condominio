<?php

namespace App\Traits\Models;

trait ResidentFilterTrait {
    public function whereResident(): self 
    {

        /**
         * Adiciona uma condição de `where` para filtrar registros pelo residente autenticado.
         * 
         * 
         * @return self
         */

        if (auth()->inGroup('user')) {
            $this->where("{$this->table}.resident_id", auth()->user()->resident_id);
        }
        return $this;
    }
}