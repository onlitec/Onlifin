<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'due_date',
        'receipt_date',
        'description',
        'observation',
        'status',
        'type'
    ];

    protected $casts = [
        'due_date' => 'date',
        'receipt_date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 