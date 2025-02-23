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

        // Converte o valor para centavos sem multiplicar por 100
        $amount = (float) $validated['amount'];
        $amount = round($amount * 100); // Converte para centavos

        // Log para debug
        \Log::info('Valor recebido:', [
            'original' => $validated['amount'],
            'convertido' => $amount
        ]);

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
        // Verifica se o usuário tem permissão para editar esta transação
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        $accounts = Account::all();

        return view('transactions.edit', compact('transaction', 'categories', 'accounts'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Verifica se o usuário tem permissão para editar esta transação
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
        ]);

        // Converte o valor para centavos
        $validated['amount'] = $validated['amount'] * 100;

        $transaction->update($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transaction $transaction)
    {
        // Implementar lógica de exclusão
    }
} 