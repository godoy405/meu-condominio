<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Occurrence;
use App\Models\OccurrenceModel;
use App\Validation\OccurrenceValidation;
use CodeIgniter\HTTP\RedirectResponse;

class OccurrencesController extends BaseController
{
    private OccurrenceModel $model;

    public function __construct()
    {
        $this->model = model(OccurrenceModel::class);
    }

    public function index()
    {
        $data = [
            'title'     => 'Gerenciar ocorrências',
            'occurrences' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('Occurrences/index', $data);
    }

    public function new()
    {
        $data = [
            'title'    => 'Novo nova ocorrência',
            'occurrence' => new Occurrence(),
            'route'    => route_to('occurrences.create'),
        ];

        return view('Occurrences/form', $data);
    }

    public function create(): RedirectResponse
    {
        $rules = (new OccurrenceValidation)->getRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $occurrence = new Occurrence($this->validator->getValidated());  
        $occurrence->resident_id = auth()->user()->id;   
        $id = $this->model->insert($occurrence);
        $occurrence = $this->model->find($id);

        return redirect()->route('occurrences.show', [$occurrence->code])
            ->with('success', 'Sucesso!');
    }

    public function show(string $code)
    {
        $occurrence = $this->model->getByCode(code: $code, contains: ['resident', 'updates']);

        $data = [
            'title'    => 'Detalhes da ocorrência',
            'occurrence' => $occurrence,
        ];

        return view('Occurrences/show', $data);
    }
   
}
