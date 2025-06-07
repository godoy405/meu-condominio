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

        return view('reservations/index', $data);    }
 


}