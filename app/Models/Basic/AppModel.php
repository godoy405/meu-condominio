<?php

namespace App\Models;

use CodeIgniter\Model;

abstract class AppModel extends Model
{
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;   
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;  

    
    protected bool $updateOnlyChanged = false;

  
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';   

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData', 'setCode'];   
    protected $beforeUpdate   = ['escapeData'];

    protected function escapeData(array $data): array
    {
        return esc($data);  
    }

    protected function setCode(array $data): array
    {
        // para gerar um número aleatório de 8 dígitos
        $code = rand(10000000, 99999999);

        $result = $this->select('code')->where('code', $code)->countAllResults();

        do {
            
            #code
        } while ($result > 0);

        $data['data']['code'] = $code;

        return $data;
    }

   
}
