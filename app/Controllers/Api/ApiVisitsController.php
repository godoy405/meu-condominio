<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\VisitModel;
use CodeIgniter\I18n\Time;

class ApiVisitsController extends BaseController
{
    use ResponseTrait;

    public function checkin(): ResponseInterface
    {
        $data = esc($this->request->getJSON(true));
        $code = $data['code'] ?? null;

        if (!$code) {
            return $this->respond([
                'success' => false,
                'message' => 'Code is missing',
            ], 400);
        }
        
        $model = model(VisitModel::class);
        $visit = $model->where('code', $code)->first();

        if (!$visit) {
            return $this->respond([
                'success' => false,
                'message' => 'Visit not found',
            ], 404);
        }
        

        if (!$visit->isValid()) {
            return $this->respond([
                'success' => false,
                'message' => 'Visit already checked in',
            ], 400);
        }

        $dataToUpdate = [
            'is_used' => true,
            'used_in' => date('Y-m-d H:i:s'),
        ];

        $model->set($dataToUpdate)->where('code', $visit->code)->update();

        return $this->respond([
            'success' => true,
            'message' => 'Visit checked in',
        ], 200);
    }
}
