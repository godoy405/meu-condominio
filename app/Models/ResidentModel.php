<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Entities\Resident;

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

}
