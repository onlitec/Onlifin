<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $selectedDate;
    public $showFormModal = false;
    public $transactionType = 'expense';
    public $formData = [
        'amount' => '',
        'description' => '',
        'observation' => '',
        'category_id' => '',
        'status' => 'pending',
        'type' => 'variable'
    ];

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function openFormModal($date, $type = 'expense')
    {
        $this->selectedDate = $date;
        $this->transactionType = $type;
        $this->showFormModal = true;
    }

    public function saveTransaction()
    {
        $this->validate([
            'formData.amount' => 'required|numeric|min:0',
            'formData.description' => 'required|string|max:255',
            'formData.status' => 'required|in:pending,paid,received',
            'formData.type' => 'required|in:fixed,variable',
        ]);

        $data = array_merge($this->formData, [
            'user_id' => auth()->id(),
            'due_date' => $this->selectedDate,
        ]);

        if ($this->transactionType === 'expense') {
            Expense::create($data);
        } else {
            Income::create($data);
        }

        $this->showFormModal = false;
        $this->reset('formData');
        $this->dispatch('transaction-saved');
    }

    public function getMonthTransactions()
    {
        $startOfMonth = Carbon::parse($this->selectedDate)->startOfMonth();
        $endOfMonth = Carbon::parse($this->selectedDate)->endOfMonth();

        return [
            'expenses' => Expense::whereBetween('due_date', [$startOfMonth, $endOfMonth])->get(),
            'incomes' => Income::whereBetween('due_date', [$startOfMonth, $endOfMonth])->get(),
        ];
    }

    public function render()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        return view('livewire.dashboard', [
            'todayExpenses' => Expense::where('due_date', $today)
                ->where('status', 'pending')
                ->get(),
            'tomorrowExpenses' => Expense::where('due_date', $tomorrow)
                ->where('status', 'pending')
                ->get(),
            'todayIncomes' => Income::where('due_date', $today)
                ->where('status', 'pending')
                ->get(),
            'tomorrowIncomes' => Income::where('due_date', $tomorrow)
                ->where('status', 'pending')
                ->get(),
            'monthTransactions' => $this->getMonthTransactions(),
        ])->layout('components.layouts.app');
    }
} 