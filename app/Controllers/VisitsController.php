<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\VisitModel;
use App\Entities\Visit;
use CodeIgniter\HTTP\RedirectResponse;

class VisitsController extends BaseController
{
    private VisitModel $model;
    

    public function __construct()
    {
        $this->model = model(VisitModel::class);
       
    }

    public function index()
    {
        
        $data = [
            'title'  => 'Gerenciar visitas',
            'visits' => $this->model->all(),
        ];

        return view('Visits/index', $data);
    }

    public function new()
    {
        
        $data = [
            'title' => 'Criar nova visita',
            'visit' => new Visit(),           
            'route' => route_to('visits.create'),
        ];

        return view('Visits/form', $data);
    }

    public function create(): RedirectResponse 
    {
        $rules = [
            'name' => 'required|max_length[128]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $visit = new Visit($this->validator->getValidated());       
        $this->model->insert($visit);        
          
        return redirect()->route('visits')->with('success', 'Sucesso !');
                             
    }

    public function destroy(string $code): RedirectResponse 
    {

        $this->model->whereResident()->where('code', $code)->delete();
            return redirect()->route('visits')->with('success', 'Sucesso!');

    }
  
}