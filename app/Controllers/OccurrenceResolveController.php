<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enum\Occurrence\Status;
use App\Models\OccurrenceModel;
use CodeIgniter\HTTP\RedirectResponse;

class OccurrenceResolveController extends BaseController
{
    private OccurrenceModel $model;

    public function __construct()
    {
        $this->model = model(OccurrenceModel::class);
    }

    public function index(string $code)
    {
        $occurrence = $this->model->getByCode(code: $code);
        $data = [
            'title'      => 'Encerrar  ocorrência',
            'occurrence' => $occurrence,
            'route'      => route_to('occurrences.resolve.process', $occurrence->code),
            // Não precisamos mais do campo hidden para método PUT
        ];

        return view('Occurrences/Resolve/form', $data);
    }

    public function process(string $code): RedirectResponse
    {
        $data = [
            'status' => Status::Closed->value,
            'solution' => $this->request->getPost('solution'),
            'updated_at' => date('Y-m-d H:i:s'),           
        ];

        $this->model->set($data)->where('code', $code)->update();
        
        return redirect()->route('occurrences.show', [$code])
            ->with('success', 'Sucesso!');
    }
   
}
