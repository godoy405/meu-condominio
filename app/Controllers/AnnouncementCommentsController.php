<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Models\ResidentModel;
use App\Traits\Entities\ResidentFilterTrait;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;


class AnnouncementCommentsController extends BaseController
{

   use ResponseTrait;

    private AnnouncementModel $model;    

    public function __construct()
    {
        $this->model = model(AnnouncementModel::class);
        
    }

    public function create(string $code): ResponseInterface|RedirectResponse
    {

        $announcement = $this->model->getByCode(code: $code);
        $now = date('Y-m-d H:i:s');
        $comment = $this->request->getPost('comment');
        $dataToInsert = esc([
            'announcement_id' => $announcement->id,
            'resident_id' => auth()->user()->resident_id,
            'comment' => $comment,
            'created_at' => $now,
        ]);

        db_connect()->table('announcement_comments')->insert($dataToInsert);


        return $this->respond([
            'token' => csrf_hash(), //! Para atualizar o token no front
            'success' => true,
            'comment' => [
                'comment' => $comment,
                'created_at' => $now,
                'resident' => model(ResidentModel::class)->getLoggedResident()->name,
            ],
        ], 201);
     

    }
   
}