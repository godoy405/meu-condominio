<?php

namespace App\Validation;

class AnnouncementValidation
{ 
    public function getRules(): array {

        return [     
            
            'resident_id' => [
                'rules' => [
                    'required',
                    'is_not_unique[residents.id]',                    
                ],              
            ],

            'title' => [
                'rules' => [
                    'required',                                  
                ],                
            ],

            'is_public' => [
                'rules' => [
                    'required',                                  
                ],                
            ],

            'content' => [
                'rules' => [
                    'required',                                  
                ],                
            ],
         
        ];

    }
    
}