<?php

namespace App\Cells\Bills;

use App\Entities\Bill;
use CodeIgniter\View\Cells\Cell;

class FormInputsCell extends Cell
{
   protected ? Bill $bill = null;

   public function getBillProperty(): ? Bill
   {
      return $this->bill;

   }
   
}
