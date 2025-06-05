<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Area;
use App\Models\ResidentModel;
use App\Validation\AreaValidation;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AreaModel;


class AreasController extends BaseController
{
    private AreaModel $model;
    public function __construct()
    {
        $this->model = model(AreaModel::class);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Gerenciar áreas de lazer',
            'areas' => $this->model->orderBy('name', 'ASC')->findAll()
        ];
        return view('Areas/index', $data);
    }

    public function new()
    {
        $data = [
            'title'    => 'Novo residente',
            'resident' => new Resident(),
            'route'    => route_to('residents.create'),
        ];

        return view('residents/form', $data);
    }

    public function create(): RedirectResponse
    {
        $rules = (new ResidentValidation)->getRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $resident = new Resident($this->validator->getValidated());     
        $id = $this->model->insert($resident);
        $resident = $this->model->find($id);

        return redirect()->route('residents.show', [$resident->code])
            ->with('success', 'Sucesso!');
    }

}
