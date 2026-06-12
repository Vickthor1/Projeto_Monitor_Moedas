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
        Schema::create('historico_consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('moeda_origem');
            $table->string('moeda_destino');
            $table->decimal('valor_origem', 15, 2);
            $table->decimal('valor_convertido', 15, 2);
            $table->decimal('taxa_cambio', 18, 8);
            $table->dateTime('data_consulta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_consultas');
    }
};
