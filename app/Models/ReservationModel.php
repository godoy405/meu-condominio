<?php

namespace App\Models;

use Exception;
use App\Enum\Reservation\Status;
use App\Entities\Reservation;
use App\Models\Basic\AppModel;
use App\Traits\Models\ResidentFilterTrait;
use App\Models\BillModel;


class ReservationModel extends AppModel
{

    use ResidentFilterTrait;

    public function __construct()
    {
        parent::__construct();
        $this->beforeInsert = array_merge($this->beforeInsert, ['setInitialData']);
    }

    protected $table            = 'reservations';    
    protected $returnType       = Reservation::class;   
    protected $allowedFields    = [        
        'area_id',
        'resident_id',
        'notes',    
        'status',
        'reason_status',
        'desired_date',    
    ];  

    public function setInitialData(array $data): array
    {
        $data['data']['status'] = Status::PENDING;
        $data['data']['reason_status'] = 'Pendente'; // Valor fixo em vez de ->label()
        $data['data']['resident_id'] = auth()->user()->resident_id ?? null;

        return $data;
    }

    public function all(): array 
    {

        $this->whereResident();

        $this->select([
            'reservations.*',
            'areas.name As area',
        ]);

        $this->join('areas', 'areas.id = reservations.area_id');

        $this->orderBy('reservations.created_at', 'DESC');

        return $this->findAll();
    }

    public function getByCode(string $code, array $contains = []): object
    {
        $this->whereResident();

        // Recupera a reserva pelo código
        $reservation = parent::getByCode(code: $code);

        if ($reservation === null) {
            throw new \RuntimeException("Reserva com código {$code} não encontrada");
        }

        // Relaciona dados adicionais, se necessário
        $this->relateData($reservation, $contains);

        return $reservation;
    }


    protected function relateData(object &$reservation, array $contains = []): void
    {
        if (in_array('bill', $contains)) {
         
           $reservation->bill = model(BillModel::class)->where('reservation_id', $reservation->id)->first();
        } 

        if (in_array('resident', $contains)) {           
            $reservation->resident = model(ResidentModel::class)->where('id', $reservation->resident_id)->first();
        }

        if (in_array('area', $contains)) {           
            $reservation->area = model(AreaModel::class)->where('id', $reservation->area_id)->first();
        }
        
    }

    public function markAs(string $code, string $status): bool
    {
        $data = [
            'status' => $status,
            // Se precisar de label, ajuste conforme necessário
        ];

        return $this->set($data)      
             ->where('code', $code)
             ->update();
    }

}
