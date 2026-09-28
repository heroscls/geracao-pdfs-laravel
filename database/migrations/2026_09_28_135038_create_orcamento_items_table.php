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
        Schema::create('orcamento_itens', function (Blueprint $table) {
            $table->id();
            // Chave estrangeira: cada item pertence a um orçamento.
            // cascadeOnDelete = se apagar o orçamento, apaga os itens juntos.
            $table->foreignId('orcamento_id')->constrained('orcamentos')->cascadeOnDelete();
            $table->string('descricao');
            $table->unsignedInteger('quantidade');
            $table->decimal('valor_unitario', 10, 2);    // Ex.: 1500.00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamento_items');
    }
};
