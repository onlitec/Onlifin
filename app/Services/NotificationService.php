<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Notifications\DueTransactionWhatsApp;
use App\Notifications\AdminTransactionNotification;
use Carbon\Carbon;

class NotificationService
{
    public function sendDueNotifications()
    {
        $tomorrow = Carbon::tomorrow();
        
        $transactions = Transaction::with(['user'])
            ->whereDate('date', $tomorrow)
            ->where('status', 'pending')
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->user->notify(new DueTransactionWhatsApp([
                'id' => $transaction->id,
                'type' => $transaction->type === 'income' ? 'receita' : 'despesa',
                'amount' => number_format($transaction->amount / 100, 2, ',', '.'),
                'due_date' => $transaction->date->format('d/m/Y'),
                'description' => $transaction->description
            ]));
        }
    }

    public function notifyAdmins(Transaction $transaction, string $action)
    {
        $admins = User::where('is_admin', true)->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new AdminTransactionNotification([
                'id' => $transaction->id,
                'action' => $action,
                'type' => $transaction->type === 'income' ? 'Receita' : 'Despesa',
                'amount' => number_format($transaction->amount / 100, 2, ',', '.'),
                'description' => $transaction->description,
                'user_id' => $transaction->user_id,
                'user_name' => $transaction->user->name
            ]));
        }
    }
} 