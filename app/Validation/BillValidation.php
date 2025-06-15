<?php

namespace App\Validation;

class BillValidation
{ 
    public function getRules(): array {

        return [     
            
            'resident_id' => [
                'rules' => [
                    'required',
                    'is_not_unique[residents.id]',                    
                ],              
            ],

            'amount' => [
                'rules' => [
                    'required',                                  
                ],                
            ],

            'status' => [
                'rules' => [
                    'required',                                  
                ],                
            ],

            'due_date' => [
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