<?php

namespace App\Controllers;

use App\Models\ResidentModel;
use App\Models\BillModel;
use App\Models\OccurrenceModel;
use App\Models\ReservationModel;
use App\Models\AnnouncementModel;

class HomeController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home'
        ];

        $data = $this->getTotals($data);
        return view('Home/index', $data);
    }

    public function getTotals(array $data): array
    {
            $amountPedingBills = model(BillModel::class)
                ->whereResident()
                ->sumBillsStatus(status: 'pending');
            $data['amount_pending_bills'] = show_price($amountPedingBills);              
            $data['total_occurrences'] = model(OccurrenceModel::class)->whereResident()->countAllResults();      
            $data['total_reservations'] = model(ReservationModel::class)->whereResident()->countAllResults();   
        
            
        if(auth()->user()->inGroup('user')){
            
            $data['total_announcements'] = model(AnnouncementModel::class)->whereResident()->countAllResults();
               
            return $data;
        }
 
        $data['total_residents'] = model(ResidentModel::class)->countAllResults();
    
        return $data;
    }
}