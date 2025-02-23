<?php

namespace App\Livewire\Expenses;

use Livewire\Component;

class ExpenseList extends Component
{
    public function render()
    {
        return view('livewire.expenses.expense-list')
            ->layout('layouts.app');
    }
} 