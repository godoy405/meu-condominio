<?php

namespace App\Traits\Entities;

trait ResidentFilterTrait
{
    public function canBeDeleted(): bool
    {
        if(auth()->user()->inGroup('superadmin')) {
            return true;
           
        }

        return $this->resident_id === (int) auth()->user()->resident_id;
    }

}