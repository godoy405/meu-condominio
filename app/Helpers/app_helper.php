<?php
use CodeIgniter\Shield\Entities\User;

if(! function_exists('get_syndic')){

    function get_syndic() : User {

        return auth()->getProvider()
        ->join('auth_groups_users', 'auth_groups_users.user_id = auth_users.id')
        ->where('auth_groups_users.group', 'superadmin')
        ->first() ?? throw new Exception("não foi encontrado o síndico da aplicação", EXIT_ERROR);

    }
}