<?php

namespace App\Services\Notifier\Email;

use CodeIgniter\Email\Email as EmailService;

class NotifierService 
{

    Public function send(string $to, string $subject, string $body): bool
    {
        /** @var EmailService */
        $email = service('email', null, false);
        $result = $email->setTo($to)
                        ->setSubject($subject)
                        ->setMessage($body)
                        ->send(true);

        if (! $result) {
            log_message('error', $email->printDebugger('headers'));
            return false;
        }

        return true;
    }

}