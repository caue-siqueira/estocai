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
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');  // Nome do relatório (ex: relatorio_2025-07-01_A_2025-07-31)
            $table->date('data_inicial');  // Data inicial do relatório
            $table->date('data_final');    // Data final do relatório
            $table->string('caminho_arquivo')->nullable();  // Caminho do arquivo gerado (se estiver gerando PDFs)
            $table->enum('status', ['pendente', 'gerado', 'erro'])->default('pendente');  // Status do relatório
            $table->timestamps();  // Campos de created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorios');
    }
};
