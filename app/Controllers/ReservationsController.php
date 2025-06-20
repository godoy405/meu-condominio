<?php

namespace App\Controllers;

use App\Services\NotifierService;
use App\Controllers\BaseController;
use App\Models\ReservationModel;
use App\Validation\ReservationValidation;
use App\Helpers\app_helper;
use CodeIgniter\HTTP\RedirectResponse;
use App\Entities\Reservation;
use App\Models\AreaModel;
use App\Enum\Reservation\Status;

class ReservationsController extends BaseController
{
    private ReservationModel $model;
    private NotifierService $notifier;

    public function __construct()
    {
        $this->model = model(ReservationModel::class);
        $this->notifier = new NotifierService();
    }

    /**
     * @return string
     */


    public function index()
    {
        
        $data = [
            'title'        => 'Gerenciar reservas',
            'reservations' => $this->model->all(),
        ];

        return view('reservations/index', $data);
    }

    public function new()
    {
        
        $data = [
            'title'       => 'Criar nova reserva',
            'reservation' => new Reservation(),
            'areas'        => model(AreaModel::class)->orderBy('name', 'ASC')->findAll(),
            'route'       => route_to('reservations.create'),
        ];

        return view('reservations/form', $data);
    }

    public function create(): RedirectResponse 
    {
        $rules = (new ReservationValidation)->getRules();

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $reservation = new Reservation($this->validator->getValidated());
        $id = $this->model->insert($reservation);
        
        // Busca a reserva completa com os relacionamentos
        $reservation = $this->model->select('reservations.*, areas.name as area_name')
                                 ->join('areas', 'areas.id = reservations.area_id')
                                 ->asObject(Reservation::class)
                                 ->find($id);

        // Adiciona o email do usuário autenticado
        $reservation->resident_email = auth()->user()->email;

        try {
            // Enviar notificações
            if (!$this->notifier->sendReservationCreatedNotification($reservation)) {
                return redirect()->route('reservations.show', [$reservation->code])
                                ->with('success', 'Reserva criada com sucesso!')
                                ->with('warning', 'Não foi possível enviar o email de notificação.');
            }
            
            return redirect()->route('reservations.show', [$reservation->code])
                             ->with('success', 'Reserva criada com sucesso!');
        } catch (\Exception $e) {
            log_message('error', '[Reserva] Erro ao enviar email: ' . $e->getMessage());
            
            return redirect()->route('reservations.show', [$reservation->code])
                             ->with('success', 'Reserva criada com sucesso!')
                             ->with('warning', 'Não foi possível enviar o email de notificação.');
        }
    }

    public function show(string $code)
    {
        try {
            $reservation = $this->model->getByCode(code: $code, contains: ['resident', 'bill', 'area']);
            
            if ($reservation === null) {
                throw new \RuntimeException('Reserva não encontrada');
            }

            // Log temporário para debug
            log_message('debug', 'Dados da reserva: ' . json_encode($reservation));

            $data = [
                'title'       => "Detalhes da Reserva #{$reservation->code}",
                'reservation' => $reservation,
            ];

            return view('reservations/show', $data);
        } catch (\Exception $e) {
            log_message('error', '[Erro ao carregar reserva] ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'Erro ao carregar os detalhes da reserva: ' . $e->getMessage());
        }
    }

    public function cancel(string $code): RedirectResponse 
    {
        try {
            $reservation = $this->model->getByCode($code);
            
            // Adicionando logs para debug
            log_message('debug', 'Tentando cancelar reserva: ' . $code);
            log_message('debug', 'Status atual: ' . $reservation->status);
            
            if (!$reservation->canBeCanceled()) {
                log_message('debug', 'Não foi possível cancelar - Status não permite');
                return redirect()->back()
                                ->with('error', 'Não é possível cancelar essa reserva. Status atual: ' . $reservation->status());
            }
            
            if ($this->model->markAs(code: $reservation->code, status: Status::CANCELLED)) {
                // Adiciona o email do usuário autenticado
                $reservation->resident_email = auth()->user()->email;

                // Enviar notificações
                if (!$this->notifier->sendCancellationNotification($reservation, 'Cancelamento solicitado pelo usuário')) {
                    return redirect()->route('reservations.show', [$reservation->code])
                                    ->with('success', 'Reserva cancelada com sucesso!')
                                    ->with('warning', 'Não foi possível enviar o email de notificação.');
                }

                return redirect()->route('reservations.show', [$reservation->code])
                                ->with('success', 'Reserva cancelada com sucesso!');
            }

            return redirect()->back()
                            ->with('error', 'Não foi possível cancelar a reserva. Tente novamente.');
            
        } catch (\Exception $e) {
            log_message('error', '[Reserva] Erro ao cancelar: ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'Erro ao processar o cancelamento: ' . $e->getMessage());
        }
    }


}