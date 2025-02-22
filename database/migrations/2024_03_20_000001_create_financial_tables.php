<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de categorias
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // expense ou income
            $table->timestamps();
        });

        // Tabela de despesas
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->string('description');
            $table->text('observation')->nullable();
            $table->string('status'); // pending, paid
            $table->string('type'); // fixed, variable
            $table->timestamps();
        });

        // Tabela de receitas
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->date('receipt_date')->nullable();
            $table->string('description');
            $table->text('observation')->nullable();
            $table->string('status'); // pending, received
            $table->string('type'); // fixed, variable
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('categories');
    }
}; 