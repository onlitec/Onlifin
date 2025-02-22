<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Remover a chave estrangeira
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained();
        });
    }
}; 