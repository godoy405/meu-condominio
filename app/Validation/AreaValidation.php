<?php

namespace App\Validation;

class AreaValidation
{ 
    public function getRules(?string $code = null): array {

        return [
            'id' => [
                'rules' => 'permit_empty|is_natural_no_zero'
            ],

            'name' => [
                'rules' => [
                    'required',
                    'max_length[100]',
                    "is_unique[areas.name, code, {$code}]"
                ],              
            ],

            'description' => [
                'rules' => [
                    'required', 
                    'max_length[50000]',                   
                ],                
            ],
         
        ];

    }
    
}