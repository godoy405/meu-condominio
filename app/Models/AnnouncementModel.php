<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Entities\Announcement;
use App\Traits\Models\ResidentFilterTrait;

class AnnouncementModel extends AppModel
{
    use ResidentFilterTrait;
    
    protected $table            = 'announcements';        
    protected $returnType       = Announcement::class;    
    protected $allowedFields    = [        
        'resident_id',
        'is_public',
        'content',        
    ];      

    public function getByCode(string $code, array $contains = []): ?Announcement
    {
        $announcement = $this->where('code', $code)->first();
        
        if ($announcement && !empty($contains)) {
            $this->relateData($announcement, $contains);
        }
        
        return $announcement;
    }

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
            $builder->join('residents', 'announcement_comments.resident_id = residents.id');
            $builder->where('announcement_comments.announcement_id', $announcement->id);
            $builder->orderBy('announcement_comments.created_at', 'DESC');

            $announcement->comments = $builder->get()->getResult();
         }
    }
}
