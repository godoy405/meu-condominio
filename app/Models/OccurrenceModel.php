<?php

namespace App\Models;

use App\Entities\Occurrence;
use App\Models\Basic\AppModel;
use App\Traits\Models\ResidentFilterTrait;



class OccurrenceModel extends AppModel
{

    use ResidentFilterTrait;

    protected $table            = 'occurrences';    
    protected $returnType       = Occurrence::class;  
    protected $allowedFields    = [                
        'resident_id',
        'title',    
        'status',
        'description',          
    ];     

    protected function relateData(object &$occurrence, array $contains = []): void
    {
       
        if (in_array('resident', $contains)) {           
            $occurrence->resident = model(ResidentModel::class)->where('id', $occurrence->resident_id)->first();
        }

        if (in_array('updates', $contains)) {           
            $occurrence->updates = $this->db->table('occurrence_updates')
                ->where('occurrence_id', $occurrence->id)
                ->orderBy('created_at', 'desc')
                ->get()->getResult();
        }
        
    }
    

}
