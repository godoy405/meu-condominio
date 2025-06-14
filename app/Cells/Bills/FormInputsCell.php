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
   
   public function render(): string
   {
      // Caminho absoluto para o arquivo de template
      $viewPath = APPPATH . 'Cells/Bills/form_inputs.php';
      
      // Garantir que $this->data seja um array
      $data = $this->data ?? [];
      
      // Adicionar a propriedade $bill ao array de dados
      $data['bill'] = $this->bill;
      
      // Extrair os dados para o template
      extract($data);
      
      // Iniciar o buffer de saída
      ob_start();
      
      // Incluir o arquivo de template
      include $viewPath;
      
      // Retornar o conteúdo do buffer
      return ob_get_clean();
   }
}