<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Resident;
use App\Models\ResidentModel;
use App\Validation\ResidentValidation;
use CodeIgniter\HTTP\RedirectResponse;

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

    public function new()
    {
        $data = [
            'title'    => 'Novo residentes',
            'resident' => new Resident(),
            'route'    => route_to('residents.create'),            
        ];

        return view('residents/form', $data);
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

        public function update(string $code): RedirectResponse {
            $rules = (new ResidentValidation)->getRules(code: $code);
            if (!$this->validate($rules)) {
                return redirect()->back()
                                ->withInput()
                                ->with('errors', $this->validator->getErrors());
            }

            $resident = $this->model->getByCode(code: $code);
            $resident->fill($this->request->getPost());

            if (!$this->model->save($resident)) {
                return redirect()->back()
                                ->withInput()
                                ->with('errors', $this->model->errors());
            }

            return redirect()->route('residents.show', [$resident->code])
                            ->with('success', 'Residente atualizado com sucesso');
        }

}
