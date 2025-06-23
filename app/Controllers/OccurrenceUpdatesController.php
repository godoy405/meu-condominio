<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\OccurrenceModel;
use App\Enum\Occurrence\Status;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;



class OccurrenceUpdatesController extends BaseController
{

   use ResponseTrait;

    private OccurrenceModel $model;    

    public function __construct()
    {
        $this->model = model(OccurrenceModel::class);
        
    }

    public function create(string $code): ResponseInterface
    {

        $occurrence = $this->model->getByCode(code: $code);
        $now = date('Y-m-d H:i:s');
        $description = $this->request->getPost('description');
        
        // Validação básica
        if (empty($description)) {
            return $this->respond([
                'token' => csrf_hash(),
                'success' => false,
                'message' => 'A descrição é obrigatória'
            ], 400);
        }
        
        $dataToInsert = esc([
            'occurrence_id' => $occurrence->id,
            'description'   => $description,
            'created_at'    => $now,
        ]);

        $this->model->set('status', Status::Progress->value)->where('code', $occurrence->code)->update();

        try {
            $result = db_connect()->table('occurrence_updates')->insert($dataToInsert);
            
            if (!$result) {
                throw new \Exception('Falha ao inserir atualização');
            }
            
            return $this->respond([
                'token' => csrf_hash(), //! Para atualizar o token no front
                'success' => true,
                'update' => [
                    'description' => $description,
                    'created_at'  => $now,                
                ], 
            ], 201);
        } catch (\Exception $e) {
            return $this->respond([
                'token' => csrf_hash(),
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
   
}