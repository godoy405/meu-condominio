<?php

namespace App\Validation;

class UserValidation
{
    public function getRules(?int $id = null): array 
    {

       return [
            'id' => [
                'rules' => 'permit_empty|is_natural_zero'
            ],           
            'email' => [
                'label' => 'Auth.email',
                'rules' => [
                    'required',
                    'max_length[254]',
                    'valid_email',
                    "is_unique[auth_identities.secret,user_id,{$id}]",
                ],
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => [
                        'required',
                        'max_byte[72]',
                        'strong_password[]',
                    ],
                'errors' => [
                    'max_byte' => 'Auth.errorPasswordTooLongBytes'
                ]
            ],
            'password_confirm' => [
                'label' => 'Auth.passwordConfirm',
                'rules' => 'required|matches[password]',
            ],
        ];
    }
}
