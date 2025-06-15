<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Traits\Models\ResidentFilterTrait;
use App\Entities\Bill;


class BillModel extends AppModel
{

    use ResidentFilterTrait;

    protected $table            = 'bills';    
    protected $returnType       = Bill::class;   
    protected $allowedFields    = [        
        'reservation_id',
        'resident_id',
        'notes',    
        'status',
        'amount',
        'due_date',    
    ];  
    
    public function sumBillsStatus(string $status): float|int
    {
        return $this->selectSum('amount')->where('status', $status)->first() ?? 0;
    }

    public function all(): array 
    {

        $this->whereResident();

        return $this->orderBy('create_at', 'DES')->findAll();
    }

    public function getByCode(string $code, array $contains = []): object
    {
        $this->whereResident();

        // Recupera a reserva pelo código
        $bill = parent::getByCode(code: $code);

        if ($bill === null) {
            throw new \RuntimeException("Reserva com código {$code} não encontrada");
        }

        // Relaciona dados adicionais, se necessário
        $this->relateData($bill, $contains);

        return $bill;
    }


    protected function relateData(object &$bill, array $contains = []): void
    {
       
        if (in_array('resident', $contains)) {           
            $bill->resident = model(ResidentModel::class)->where('id', $bill->resident_id)->first();
        }

        if (in_array('reservation', $contains)) {           
            $bill->reservation = model(ReservationMOdel::class)->where('id', $bill->reservation_id)->first();
        }
        
    }
    

}
