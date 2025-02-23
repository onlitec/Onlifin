<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'date',
        'description',
        'amount',
        'category_id',
        'account_id',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
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
}