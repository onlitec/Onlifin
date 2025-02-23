<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;

class FormModal extends Component
{
    public $type = 'expense';
    public $description = '';
    public $amount = '';
    public $date;
    public $account_id = '';
    public $category_id = '';
    public $note = '';
    public $showRepeat = false;
    public $showNote = false;
    public $showAttachment = false;
    public $showTags = false;

    protected $rules = [
        'description' => 'required|min:3',
        'amount' => 'required|numeric|min:0.01',
        'date' => 'required|date',
        'account_id' => 'required|exists:accounts,id',
        'category_id' => 'required|exists:categories,id',
    ];

    public function mount($type = null)
    {
        if ($type) {
            $this->type = $type;
        }
        $this->date = now()->format('Y-m-d');
    }

    public function toggleRepeat()
    {
        $this->showRepeat = !$this->showRepeat;
    }

    public function toggleNote()
    {
        $this->showNote = !$this->showNote;
    }

    public function toggleAttachment()
    {
        $this->showAttachment = !$this->showAttachment;
    }

    public function toggleTags()
    {
        $this->showTags = !$this->showTags;
    }

    public function save()
    {
        $this->validate();

        Transaction::create([
            'description' => $this->description,
            'amount' => $this->amount,
            'date' => $this->date,
            'account_id' => $this->account_id,
            'category_id' => $this->category_id,
            'type' => $this->type,
            'note' => $this->note,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
        $this->dispatch('transactionSaved');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function updatedAmount($value)
    {
        if (!empty($value)) {
            // Remove R$ e espaços
            $value = str_replace(['R$', ' '], '', $value);
            // Substitui pontos por nada e vírgula por ponto
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
            $this->amount = (float) $value;
        }
    }

    public function render()
    {
        try {
            $accounts = Account::where('user_id', auth()->id())->get();
            $categories = Category::where('type', $this->type)->get();
        } catch (\Exception $e) {
            $accounts = collect();
            $categories = collect();
        }

        return view('livewire.transactions.form-modal', [
            'accounts' => $accounts,
            'categories' => $categories
        ]);
    }
} 