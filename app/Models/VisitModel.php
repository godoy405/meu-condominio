<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Traits\Models\ResidentFilterTrait;
use App\Enum\Visit\Status;
use App\Entities\Visit;
use CodeIgniter\I18n\Time;

class VisitModel extends AppModel
{

    use ResidentFilterTrait;

    public function __construct()
    {
        parent::__construct();
        $this->beforeInsert = array_merge($this->beforeInsert, ['setInitialData']);
    }

    protected $table            = 'visits';    
    protected $returnType       = Visit::class;
    protected $allowedFields    = [        
        'resident_id',
        'name',
        'is_used',    
        'valid_until',
        'used_in',        
    ];  

    public function setInitialData(array $data): array
    {
        $data['data']['valid_until'] = Time::now()->addHours(24)->format('Y-m-d H:i:s');
        $data['data']['is_used'] = false;
        $data['data']['resident_id'] = auth()->user()->resident_id;               
        
        return $data;
    }

    public function all(): array 
    {

        $this->whereResident();

        $this->select([
            'visits.*',
            'residents.name As resident',
        ]);

        $this->join('residents', 'residents.id = visits.resident_id');

        $this->orderBy('visits.created_at', 'DESC');

        return $this->findAll();
    }

    public function getByCode(string $code, array $contains = []): object
    {
        $this->whereResident();

        // Recupera a reserva pelo código
        $visit = parent::getByCode(code: $code);        

        // Relaciona dados adicionais, se necessário
        $this->relateData($visit, $contains);

        return $visit;
    }


    protected function relateData(object &$visit, array $contains = []): void
    {     
        if (in_array('resident', $contains)) {           
            $visit->resident = model(ResidentModel::class)->where('id', $visit->resident_id)->first();
        }
               
    }


}
