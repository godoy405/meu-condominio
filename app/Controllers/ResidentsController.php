<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ResidentModel;

class ResidentsController extends BaseController
{
    private ResidentModel $model;
    public function __construct()
    {
        $this->model = model(ResidentModel::class);
    }

    public function index()
    {
        $data = [
            'title' => 'Gerenciar residentes',
            'residents' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('residents/index', $data);
    }

    public function show(string $code)
    {
        $resident = $this->model->getByCode(code: $code);

        $data = [
            'title'    => 'Detalhes do residentes',
            'resident' => $resident,
        ];

        return view('residents/show', $data);
    }

    public function edit(string $code)
    {
        $resident = $this->model->getByCode(code: $code);

        $data = [
            'title'    => 'Editar residentes',
            'resident' => $resident,
            'route'    => route_to('residents.update', $resident->code),
            'hidden'   => ['_method' => 'PUT'],
        ];

        return view('residents/form', $data);
    }
}
