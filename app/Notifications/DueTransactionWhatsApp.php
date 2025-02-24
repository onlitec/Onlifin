<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\WhatsAppMessage;

class DueTransactionWhatsApp extends BaseNotification
{
    public function via($notifiable): array
    {
        return ['whatsapp'];
    }

    public function toWhatsApp($notifiable): WhatsAppMessage
    {
        return (new WhatsAppMessage)
            ->content("Olá {$notifiable->name}!\n\n" .
                "Você tem um(a) {$this->data['type']} " .
                "no valor de R$ {$this->data['amount']} " .
                "com vencimento para {$this->data['due_date']}.\n\n" .
                "Descrição: {$this->data['description']}")
            ->button('Ver Detalhes', url("/transactions/{$this->data['id']}"));
    }

    public function toArray($notifiable): array
    {
        return [
            'transaction_id' => $this->data['id'],
            'type' => $this->data['type'],
            'amount' => $this->data['amount'],
            'due_date' => $this->data['due_date'],
            'description' => $this->data['description']
        ];
    }
} 