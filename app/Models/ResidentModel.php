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
        'code'
    ];

    public function getLoggedResident(): Resident {
        $resident = $this->where('id', auth()->user()->resident_id)->first();

        if(!$resident) {
            throw new Exception("Residente associado ao usuário logado não foi encontrado", \EXIT_ERROR);
        }

        return $resident;
    } 

    public function getByCode(string $code, array $contains = []): Resident
    {
        $resident = $this->where('code', $code)->first();

        if (!$resident) {
            throw new Exception("Residente não encontrado", 404);
        }

        $this->relateData($resident, $contains);

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
