<?php

namespace App\Services;

class NotifierService
{
    /**
     * Envia uma notificação por email
     *
     * @param string $to Endereço de email do destinatário
     * @param string $subject Assunto do email
     * @param string $body Corpo do email
     * @return void
     */
    public function send(string $to, string $subject, string $body): void
    {
        try {
            // Implementação do envio de email
            // Você pode usar o serviço de email do CodeIgniter aqui
            $email = \Config\Services::email();
            
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($body);
            
            if (!$email->send()) {
                // Log do erro
                log_message('error', 'Falha ao enviar email: ' . $email->printDebugger(['headers']));
            }
        } catch (\Exception $e) {
            // Log do erro
            log_message('error', 'Exceção ao enviar email: ' . $e->getMessage());
        }
    }
    
    /**
     * Envia uma notificação de cancelamento de reserva
     *
     * @param object $reservation Objeto da reserva
     * @param string $reason Motivo do cancelamento
     * @return bool
     */
    public function sendCancellationNotification(object $reservation, string $reason): bool
    {
        try {
            $syndic = get_syndic();
            $to = $syndic->email;
            $subject = "Cancelamento de reserva";
            $body = "A reserva {$reservation->code} foi cancelada. Motivo: {$reason}";
            
            $this->send($to, $subject, $body);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Erro ao enviar notificação de cancelamento: ' . $e->getMessage());
            return false;
        }
    }
}