<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class CreateExpense extends Component
{
    public $description = '';
    public $amount = '';
    public $due_date = '';
    public $category = '';
    public $notes = '';

    protected $rules = [
        'description' => 'required|min:3',
        'amount' => 'required|numeric|min:0',
        'due_date' => 'required|date',
        'category' => 'required|in:food,transport,utilities,rent,healthcare,education,entertainment,other',
        'notes' => 'nullable|string'
    ];

    public function save()
    {
        $this->validate();

        auth()->user()->expenses()->create([
            'description' => $this->description,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'category' => $this->category,
            'notes' => $this->notes,
            'status' => 'pending'
        ]);

        $this->reset();
        $this->dispatch('expense-created');
        session()->flash('success', 'Despesa criada com sucesso!');
    }

    public function render()
    {
        return view('livewire.expenses.create-expense', [
            'categories' => Expense::categories()
        ]);
    }
} 