<?php
use CodeIgniter\Shield\Entities\User;

// Carregando o helper de número do CodeIgniter de forma correta
if (!function_exists('number_to_currency')) {
    helper('number');
}

if(! function_exists('get_syndic')){

    function get_syndic() : User {

        return auth()->getProvider()
        ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
        ->where('auth_groups_users.group', 'superadmin')
        ->first() ?? throw new Exception("não foi encontrado o síndico da aplicação", EXIT_ERROR);

    }
}


if(!function_exists('show_price')) {

    function show_price(int|float $price): string
    {
        return number_to_currency(num: $price / 100, currency: 'BRL', fraction: 2);
    }
}