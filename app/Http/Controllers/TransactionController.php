<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['category', 'account'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $accounts = Account::where('active', true)->orderBy('name')->get();
        
        return view('transactions.create', compact('categories', 'accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'notes' => 'nullable|string',
        ]);

        // Remove pontos e converte vírgula para ponto
        $amount = str_replace(['R$ ', '.'], '', $validated['amount']); // Remove R$ e pontos
        $amount = str_replace(',', '.', $amount); // Troca vírgula por ponto
        $amount = round((float) $amount * 100); // Converte para centavos

        $transaction = Transaction::create([
            'type' => $validated['type'],
            'date' => $validated['date'],
            'description' => $validated['description'],
            'amount' => $amount,
            'category_id' => $validated['category_id'],
            'account_id' => $validated['account_id'],
            'notes' => $validated['notes'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('transactions')->with('success', 'Transação criada com sucesso!');
    }

    public function edit(Transaction $transaction)
    {
        // Converte o valor de centavos para reais com formatação brasileira
        $transaction->amount = number_format($transaction->amount / 100, 2, ',', '.');
        $categories = Category::orderBy('name')->get();
        $accounts = Account::where('active', true)->orderBy('name')->get();
        
        return view('transactions.edit', compact('transaction', 'categories', 'accounts'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'notes' => 'nullable|string',
        ]);

        // Remove pontos e converte vírgula para ponto
        $amount = str_replace(['R$ ', '.'], '', $validated['amount']); // Remove R$ e pontos
        $amount = str_replace(',', '.', $amount); // Troca vírgula por ponto
        $amount = round((float) $amount * 100); // Converte para centavos

        $transaction->update([
            'type' => $validated['type'],
            'date' => $validated['date'],
            'description' => $validated['description'],
            'amount' => $amount,
            'category_id' => $validated['category_id'],
            'account_id' => $validated['account_id'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('transactions')->with('success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transaction $transaction)
    {
        // Implementar lógica de exclusão
    }
} 