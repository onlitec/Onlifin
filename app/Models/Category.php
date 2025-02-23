<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type' // 'expense' ou 'income'
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
} 