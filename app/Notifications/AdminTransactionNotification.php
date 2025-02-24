<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class AdminTransactionNotification extends BaseNotification
{
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Alteração em Transação - {$this->data['action']}")
            ->greeting("Olá {$notifiable->name}")
            ->line("Uma transação foi {$this->data['action']}:")
            ->line("Tipo: {$this->data['type']}")
            ->line("Valor: R$ {$this->data['amount']}")
            ->line("Descrição: {$this->data['description']}")
            ->line("Usuário: {$this->data['user_name']}")
            ->action('Ver Detalhes', url("/transactions/{$this->data['id']}"))
            ->line('Esta é uma notificação automática do sistema.');
    }

    public function toArray($notifiable): array
    {
        return [
            'transaction_id' => $this->data['id'],
            'action' => $this->data['action'],
            'type' => $this->data['type'],
            'amount' => $this->data['amount'],
            'description' => $this->data['description'],
            'user_id' => $this->data['user_id'],
            'user_name' => $this->data['user_name']
        ];
    }
} 