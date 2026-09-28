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
        Schema::create('ficha_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exercicio_id')->constrained()->cascadeOnDelete();
            $table->char('dia', 1);                       // A, B, C...
            $table->unsignedTinyInteger('ordem')->default(1);
            $table->unsignedTinyInteger('series');
            $table->string('repeticoes');                 // "12" ou "8-10"
            $table->string('carga')->nullable();          // "20kg"
            $table->unsignedSmallInteger('descanso_segundos')->default(60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_items');
    }
};
