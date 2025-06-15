<?php

namespace App\Controllers;

use App\Services\NotifierService;
use App\Controllers\BaseController;
use App\Models\ReservationModel;
use App\Models\BillModel; // Adicionando o modelo BillModel
use App\Validation\ReservationValidation;
use App\Validation\BillValidation;
use App\Helpers\app_helper;
use CodeIgniter\HTTP\RedirectResponse;
use App\Entities\Reservation;
use App\Entities\Bill; // Adicionando a entidade Bill
use App\Models\AreaModel;
use App\Enum\Reservation\Status;

class ReservationsBillsController extends BaseController
{
    private ReservationModel $model;
    private NotifierService $notifier;
    private BillModel $billModel; // Adicionando o modelo de fatura

    public function __construct()
    {
        $this->model = model(ReservationModel::class);
        $this->notifier = new NotifierService();
        $this->billModel = model(BillModel::class); // Inicializando o modelo de fatura
    }

    /**
     * @return string
     */


    public function index(string $code)
    {
        
        $reservation = $this->model->getByCode(code: $code, contains: ['resident', 'bill', 'area']);
        $route = route_to($reservation->bill === null ? 'reservations.bills.create' : 'reservations.bills.update', $reservation->code);

        $data = [
            'title'       => $reservation->bill === null ? 'Criar cobrança' : 'Editar cobrança',
            'reservation' => $reservation,
            'route'       => $route,
            'hidden'      => $reservation->bill !== null ? ['_method' => 'PUT'] : [],
        ];
        
        return view('Residents/Bill/form', $data); // Em vez de 'reservations/form'
    }

    public function new()
    {
        $reservation = new Reservation();
        $reservation->bill = null; // Definindo explicitamente como null
        
        // Adicione um residente vazio ou obtenha um residente válido
        $resident = new \App\Entities\Resident();
        
        $data = [
            'title'       => 'Criar cobrança',
            'reservation' => $reservation,
            'resident'    => $resident, // Adicionando o residente aos dados
            'route'       => route_to('reservations.bills.create'),
        ];
    
        return view('Residents/Bill/form', $data); // Corrigido para a view correta
    }

    public function create(string $code): RedirectResponse 
    {
        $rules = (new BillValidation)->getRules();
        unset($rules['resident_id']); // Removendo a validação de resident_id para evitar duplicidade


        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $reservation = $this->model->getByCode(code: $code);
       
        $bill = new Bill($this->validator->getValidated());
        $bill->reservation_id = $reservation->id; // Corrigido: usando o ID da reserva
        $bill->resident_id = $reservation->resident_id;
        

        $id = model(BillModel::class)->insert($bill);
        $bill = model(BillModel::class)->find($id);

        $this->updateReservationStatus(reservation: $reservation, bill: $bill);
        

                      
        // Redirecionando para a página da reserva após criar a fatura
        return redirect()->route('reservations.show', [$reservation->code])
                         ->with('success', 'Cobrança criada com sucesso!');
    }

    public function update(string $code): RedirectResponse
    {
        $rules = (new BillValidation)->getRules();
        unset($rules['resident_id']); // Removendo a validação de resident_id para evitar duplicidade

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $reservation = $this->model->getByCode(code: $code, contains: ['bill']);
        
        if ($reservation->bill === null) {
            return redirect()->back()
                             ->with('error', 'Não existe cobrança para esta reserva');
        }

        $bill = $reservation->bill;
        $bill->fill($this->validator->getValidated());

        $this->billModel->save($bill);
        $this->updateReservationStatus(reservation: $reservation, bill: $bill);

        return redirect()->route('reservations.show', [$reservation->code])
                         ->with('success', 'Cobrança atualizada com sucesso!');
    }

    private function updateReservationStatus(Reservation $reservation, Bill $bill): void
    {
        $reservation->status = Status::CONFIRMED; // Corrigido: usando a constante diretamente

        $reservation->reason_status = $bill->isPaid() ? 'Pagamento da reserva realizado': 'Aguardando pagamento da reserva'; 

        $this->model->save($reservation);

        // todo: o aluno pode disparar notificações para o residente.
    }
 
   
}