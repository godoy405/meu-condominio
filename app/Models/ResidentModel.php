<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Entities\Resident;
use Exception;

class ResidentModel extends AppModel
{
    protected $table            = 'residents';        
    protected $returnType       = Resident::class;    
    protected $allowedFields    = [
        'user_id',
        'name',
        'apartment',
        'mobile_phone',
    ];

    public function getLoggedResident(): Resident {
        $resident = $this->where('id', auth()->user()->resident_id)->first();

        if(!$resident) {
            throw new Exception("Residente associado ao usuário logado não foi encontrado", \EXIT_ERROR);
        }

        return $resident;
    } 

    protected function relateData(object &$resident, array $contains = []): void
    {
        if(in_array('user', $contains)) {
            $resident->user = $resident->user_id === null 
                ? null 
                : auth()->getProvider()->findById($resident->user_id);
        }
    }
}
