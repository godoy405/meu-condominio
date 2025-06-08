<?php

namespace App\Validation;

class ReservationValidation
{ 
    public function getRules(): array {

        return [          

            'area_id' => [
                'rules' => [
                    'is_not_unique[areas.id]',                    
                ],              
            ],

            'desired_date' => [
                'rules' => [
                    'required',                                  
                ],                
            ],

            'notes' => [
                'rules' => [
                    'permit_empty',                                  
                ],                
            ],
         
        ];

    }
    
}