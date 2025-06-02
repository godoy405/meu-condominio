<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ResidentUserController extends BaseController
{
    public function index(string $code)
    {
        // buscamos o residente com o possível user dele
        $resident = model(ResidentModel::class)->getByCode(code: $code, contains: ['user']);

        $route = route_to($resident->hasUser() ? 'residents.user.update' : 'residents.user.create', $resident->code)

        $data = [
            'title'     => "Usuário do residente {$resident->name}", 
            'residente' => $resident,
            'route'    => $route,
            'hidden'   => $resident->hasUser() ? ['_method' => 'PUT'] : [],
        ];
        return view('Residents/User/form', $data);

    }
}
