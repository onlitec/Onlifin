<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Modificar a coluna status para incluir 'overdue'
            $table->dropColumn('status');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');

            // Adicionar novas colunas
            $table->enum('category', [
                'food',
                'transport',
                'utilities',
                'rent',
                'healthcare',
                'education',
                'entertainment',
                'other'
            ])->after('status');
            
            $table->text('notes')->nullable()->after('category');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Reverter alterações
            $table->dropColumn(['category', 'notes', 'deleted_at']);
            
            // Restaurar status original
            $table->dropColumn('status');
            $table->enum('status', ['pending', 'paid'])->default('pending');
        });
    }
};
