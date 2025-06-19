<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Entities\Announcement;
use App\Models\AnnouncementModel;
use App\Traits\Entities\ResidentFilterTrait;
use App\Validation\AnnouncementValidation;
use CodeIgniter\HTTP\RedirectResponse;


class AnnouncementsController extends BaseController
{

    use ResidentFilterTrait;

    private AnnouncementModel $model;    

    public function __construct()
    {
        $this->model = model(AnnouncementModel::class);
        
    }

    public function index()

    {
        
        $data = [
            'title'        => 'Anúncios',
            'announcements' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('Announcements/index', $data);
    }

    public function new()
    {
        
        $data = [
            'title'        => 'Criar novo anúncio',
            'announcement' => new Announcement(),           
            'route'        => route_to('announcements.create'),
        ];

        return view('Announcements/form', $data);
    }

    public function create(): RedirectResponse 
    {
        $rules = (new AnnouncementValidation())->getRules();
        unset($rules['resident_id']);

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $announcement = new Announcement($this->validator->getValidated());
        $announcement->resident_id = auth()->user()->resident_id;
        $id = $this->model->insert($announcement);
        $announcement = $this->model->find($id);

        return redirect()->route('announcements.show', [$announcement->code])
                        ->with('success', 'Anúncio criado com sucesso!');       
     

    }


    public function show(string $code): string
    {
        $announcement = $this->model->getByCode(code: $code, contains: ['comments']);

        $data = [
            'title'        => 'Detalhes do anúncio',
            'announcement' => $announcement,            
        ];
        return view('Announcements/show', $data);
    } 


    public function destroy(string $code): RedirectResponse 
    {
        $announcement = $this->model->getByCode(code: $code);

        if ($this->model->delete($announcement->id)) {
            return redirect()->route('announcements.index')
                            ->with('success', 'Anúncio excluído com sucesso!');
        }

        return redirect()->back()
                        ->with('error', 'Não foi possível excluir o anúncio');
    }
}