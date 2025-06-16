<?php

namespace App\Models;

use App\Entities\Notification;
use App\Models\Basic\AppModel;


class NotificationModel  extends AppModel
{
    protected $table            = 'notifications';        
    protected $returnType       = Notification::class; 
    protected $allowedFields    = [        
        'title',
        'message',
        'created_at',        
    ];     

    protected $useTimestamps = false;
}
