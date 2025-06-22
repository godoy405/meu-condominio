<?php

namespace App\Validation;

class OccurrenceValidation
{ 
    public function getRules(): array {

        return [    
           'title' => [
                'rules' => [
                    'required',                                  
                ],                
            ],

            'description' => [
                'rules' => [
                    'required',                                  
                ],                
            ],          
         
        ];

    }
    
}