<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Totais gerais
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpenses = Transaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpenses;

        // Transações de hoje
        $today = now()->format('Y-m-d');
        $todayIncomes = Transaction::with(['category', 'account'])
            ->where('type', 'income')
            ->whereDate('date', $today)
            ->orderBy('date')
            ->get();

        $todayExpenses = Transaction::with(['category', 'account'])
            ->where('type', 'expense')
            ->whereDate('date', $today)
            ->orderBy('date')
            ->get();

        // Transações de amanhã
        $tomorrow = now()->addDay()->format('Y-m-d');
        $tomorrowIncomes = Transaction::with(['category', 'account'])
            ->where('type', 'income')
            ->whereDate('date', $tomorrow)
            ->orderBy('date')
            ->get();

        $tomorrowExpenses = Transaction::with(['category', 'account'])
            ->where('type', 'expense')
            ->whereDate('date', $tomorrow)
            ->orderBy('date')
            ->get();

        return view('dashboard.index', compact(
            'totalIncome',
            'totalExpenses',
            'balance',
            'todayIncomes',
            'todayExpenses',
            'tomorrowIncomes',
            'tomorrowExpenses'
        ));
    }
} 