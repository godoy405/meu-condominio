<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Controllers\BaseController;
use App\Entities\Notification;
use App\Validation\NotificationValidation; // Corrigir o import também
use CodeIgniter\HTTP\RedirectResponse;


class NotificationsController extends BaseController
{
    private NotificationModel $model; // ou NotificationsModel, dependendo da sua escolha

    public function __construct()
    {
        $this->model = model(NotificationModel::class); // ou NotificationsModel::class
    }
    
    public function index()
    {
        $viewName = auth()->user()->inGroup('superadmin') ? 'index' : 'index_user';

        $data = [
            'title'         => 'Avisos',
            'notifications' => $this->model->orderBy('created_at', 'DESC')->findAll()
        ];
        return view("Notifications/{$viewName}", $data); // Note as aspas duplas aqui
    }
    
    public function new()
    {
        $data = [
            'title'        => 'Novo aviso',
            'notification' => new Notification(),
            'route'        => route_to('notifications.create'),
        ];

        return view('Notifications/form', $data);
    }

    public function create(): RedirectResponse
    {
        $rules = (new NotificationValidation)->getRules(); // Corrigir aqui
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $notification = new Notification($this->validator->getValidated());
        $notification->created_at = date('Y-m-d H:i:s');
        $this->model->insert($notification);     

        return redirect()->route('notifications')->with('success', 'Sucesso!');
    }

    public function destroy(string $code): RedirectResponse
    {
         
        $this->model->where('code', $code)->delete();
        
        return redirect()->route('notifications')->with('success', 'Sucesso!');
    }

}
