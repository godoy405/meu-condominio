<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ResidentModel;
use App\Validation\UserValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Entities\User;

class ResidentUserController extends BaseController
{
    public function index(string $code)
    {
        // buscamos o residente com o possível user dele
        $resident = model(ResidentModel::class)->getByCode(code: $code, contains: ['user']);

        $route = route_to($resident->hasUser() ? 'residents.user.update' : 'residents.user.create', $resident->code);

        $data = [
            'title'    => "Usuário do residente {$resident->name}",
            'resident' => $resident,
            'route'    => $route,
            'hidden'   => $resident->hasUser() ? ['_method' => 'PUT'] : [],
        ];
        
        return view('Residents/User/form', $data);
    }

    public function create(string $code): RedirectResponse
    {
        $rules = (new UserValidation)->getRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //recupero sem usuário, pois estmos criando um usuário
        $resident = model(ResidentModel::class)->getByCode(code: $code);

        $user = new User([
            'username'    => mb_url_title("{$resident->name}-{$resident->code}", '-', true),
            'email'       => $this->request->getPost('email'),
            'password'    => $this->request->getPost('password'),
            'resident_id' => $resident->id
        ]);

        $userModel = auth()->getProvider();
        $userModel->setAllowedFields(['resident_id', 'username']);
        $userModel->save($user);

        $user = $userModel->findById($userModel->getInsertID());
        $userModel->addToDefaultGroup($user);

        $resident->user_id = $user->id;
        model(ResidentModel::class)->save($resident);
              
        return redirect()->route('residents.show', [$resident->code])
            ->with('success', 'Sucesso!');
    }
}
