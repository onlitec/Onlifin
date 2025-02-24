<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class SendDueNotifications extends Command
{
    protected $signature = 'notifications:due';
    protected $description = 'Envia notificações de vencimentos para o dia seguinte';

    public function handle(NotificationService $service)
    {
        $this->info('Enviando notificações de vencimento...');
        $service->sendDueNotifications();
        $this->info('Notificações enviadas com sucesso!');
    }
} 