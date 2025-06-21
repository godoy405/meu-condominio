<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BillModel;
use App\Models\ResidentModel;
use App\Validation\BillValidation;
use CodeIgniter\HTTP\RedirectResponse;


class BillsController extends BaseController
{
    private BillModel $model;
    public function __construct()
    {
        $this->model = model(BillModel::class);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Cobranças',
            'bills' => $this->model->all()
        ];
        return view('Bills/index', $data);
    }

    public function new()
    {
        $data = [
            'title'     => 'Nova cobrança',
            'bill'      => new \App\Entities\Bill(),
            'residents' => model(ResidentModel::class)->orderBy('name', 'ASC')->findAll(),
            'route'     => route_to('bills.create'),
        ];

        return view('Bills/form', $data);
    }

    public function create(): RedirectResponse
    {
        $rules = (new BillValidation)->getRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $bill = new \App\Entities\Bill($this->validator->getValidated());
        $id = $this->model->insert($bill);
        $bill = $this->model->find($id);

        return redirect()->route('bills.show', [$bill->code])->with('success', 'Cobrança criada com sucesso!');
    }

    public function show(string $code): string|RedirectResponse
    {
        try {
            $bill = $this->model->getByCode(code: $code, contains: ['resident']);
            
            $data = [
                'title' => 'Detalhes da cobrança',
                'bill'  => $bill,            
            ];

            return view('Bills/show', $data);
        } catch (\RuntimeException $e) {
            return redirect()->route('bills')
                ->with('error', $e->getMessage());
        }
    }

    public function edit(string $code): string|RedirectResponse
    {
        try {
            $bill = $this->model->getByCode(code: $code);
    
            $data = [
                'title'     => 'Editar cobrança',
                'bill'      => $bill, 
                'residents' => model(ResidentModel::class)->orderBy('name', 'ASC')->findAll(),
                'route'     => route_to('bills.update', $bill->code), 
                'hidden'    => ['_method' => 'PUT']          
            ];
    
            return view('Bills/form', $data);
        } catch (\RuntimeException $e) {
            return redirect()->route('bills')
                ->with('error', $e->getMessage());
        }
    }

    public function update(string $code): RedirectResponse
    {
        $rules = (new BillValidation)->getRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {
            $bill = $this->model->getByCode(code: $code);

            $bill->fill($this->validator->getValidated());
            $this->model->save($bill);
            
            return redirect()->route('bills.show', [$bill->code])->with('success', 'Cobrança atualizada com sucesso!');
        } catch (\RuntimeException $e) {
            return redirect()->route('bills')
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(string $code): RedirectResponse
    {
        $this->model->where('code', $code)->delete();
        
        return redirect()->route('bills')->with('success', 'Cobrança excluída com sucesso!');
    }
}
