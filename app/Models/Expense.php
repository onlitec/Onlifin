<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'due_date',
        'status',
        'category',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function categories()
    {
        return [
            'food' => 'Alimentação',
            'transport' => 'Transporte',
            'utilities' => 'Contas (Água/Luz/etc)',
            'rent' => 'Aluguel',
            'healthcare' => 'Saúde',
            'education' => 'Educação',
            'entertainment' => 'Entretenimento',
            'other' => 'Outros'
        ];
    }

    public static function statuses()
    {
        return [
            'pending' => 'Pendente',
            'paid' => 'Pago',
            'overdue' => 'Atrasado'
        ];
    }
} 