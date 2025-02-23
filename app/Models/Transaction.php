<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'status',
        'date',
        'description',
        'amount',
        'category_id',
        'account_id',
        'user_id',
        'notes'
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Acessor para formatar o valor
    public function getFormattedAmountAttribute()
    {
        return 'R$ ' . number_format($this->amount / 100, 2, ',', '.');
    }

    // Mutator para garantir que o valor seja armazenado corretamente
    public function setAmountAttribute($value)
    {
        if (is_string($value)) {
            $value = (float) str_replace(',', '.', str_replace('.', '', $value));
        }
        $this->attributes['amount'] = $value;
    }

    // Adicione estes métodos auxiliares
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
}