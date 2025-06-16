<?php

namespace App\Validation;

class NotificationValidation
{ 
    public function getRules(): array {

        return [           

            'title' => [
                'rules' => [
                    'required',                   
                ],              
            ],

            'message' => [
                'rules' => [
                    'required', 
                    'max_length[5000]',                   
                ],                
            ],
         
        ];

    }
    
}

