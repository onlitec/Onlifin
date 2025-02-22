<?php

namespace App\Livewire\Incomes;

use Livewire\Component;
use App\Models\Income;
use App\Models\Category;
use Livewire\WithPagination;
use Carbon\Carbon;

class IncomeList extends Component
{
    use WithPagination;

    public $showFormModal = false;
    public $editingIncome = null;
    public $filters = [
        'status' => '',
        'type' => '',
        'start_date' => '',
        'end_date' => '',
        'category_id' => ''
    ];

    public $formData = [
        'amount' => '',
        'description' => '',
        'observation' => '',
        'category_id' => '',
        'status' => 'pending',
        'type' => 'variable',
        'due_date' => ''
    ];

    public function mount()
    {
        $this->filters['start_date'] = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->filters['end_date'] = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function openFormModal($incomeId = null)
    {
        if ($incomeId) {
            $this->editingIncome = Income::find($incomeId);
            $this->formData = $this->editingIncome->toArray();
        } else {
            $this->reset('editingIncome', 'formData');
            $this->formData['due_date'] = now()->format('Y-m-d');
        }
        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate([
            'formData.amount' => 'required|numeric|min:0',
            'formData.description' => 'required|string|max:255',
            'formData.category_id' => 'required|exists:categories,id',
            'formData.status' => 'required|in:pending,received',
            'formData.type' => 'required|in:fixed,variable',
            'formData.due_date' => 'required|date'
        ]);

        if ($this->editingIncome) {
            $this->editingIncome->update($this->formData);
        } else {
            Income::create(array_merge($this->formData, [
                'user_id' => auth()->id()
            ]));
        }

        $this->showFormModal = false;
        $this->dispatch('income-saved');
    }

    public function delete($incomeId)
    {
        Income::destroy($incomeId);
        $this->dispatch('income-deleted');
    }

    public function render()
    {
        $query = Income::query()
            ->with('category')
            ->when($this->filters['status'], fn($q) => $q->where('status', $this->filters['status']))
            ->when($this->filters['type'], fn($q) => $q->where('type', $this->filters['type']))
            ->when($this->filters['category_id'], fn($q) => $q->where('category_id', $this->filters['category_id']))
            ->when($this->filters['start_date'], fn($q) => $q->where('due_date', '>=', $this->filters['start_date']))
            ->when($this->filters['end_date'], fn($q) => $q->where('due_date', '<=', $this->filters['end_date']))
            ->orderBy('due_date', 'desc');

        return view('livewire.incomes.income-list', [
            'incomes' => $query->paginate(10),
            'categories' => Category::where('type', 'income')->get()
        ]);
    }
} 