<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        
        // Totais do mês atual
        $totalIncome = Transaction::where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->sum('amount');
            
        $totalExpenses = Transaction::where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->sum('amount');
            
        $balance = $totalIncome - $totalExpenses;
        
        // Últimas transações
        $recentTransactions = Transaction::with(['category'])
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'balance',
            'recentTransactions'
        ));
    }
} 