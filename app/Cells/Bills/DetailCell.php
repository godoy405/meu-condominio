<?php

namespace App\Cells\Bills;

use CodeIgniter\View\Cells\Cell;
use App\Entities\Bill; // Adicionando a importação da classe Bill

class DetailCell extends Cell
{
    protected ? Bill $bill = null;

   public function getBillProperty(): ? Bill
   {
      return $this->bill;
   }
}
