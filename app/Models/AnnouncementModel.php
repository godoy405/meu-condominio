<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Entities\Announcement;

class AnnouncementModel extends AppModel
{
    protected $table            = 'announcements';        
    protected $returnType       = Announcement::class;    
    protected $allowedFields    = [        
        'resident_id',
        'is_public',
        'content',        
    ];      

    protected function relateData(object &$announcement, array $contains = []): void
    {
        if(in_array('resident', $contains)) {
           $announcement->resident = model(ResidentModel::class)->where('id', $announcement->resident_id)->first();
        }

        if(in_array('comments', $contains)) {

            $builder = $this->db->table('announcement_comments');

            $builder->select([
                'announcement_comments.*',
                'residents.name AS author',
            ]);
            $builder->join('announcement_comments', 'announcement_comments.resident_id = residents.id');
            $builder->where('announcement_comments.announcement_id', $announcement->id);
            $builder->orderBy('announcement_comments.created_at', 'DESC');

            $announcement->comments =$builder->get()->getResult();
         }
    }
}
