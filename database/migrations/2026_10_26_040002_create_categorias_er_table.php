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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('ID_Categoria');
            $table->string('Nombre');
            $table->text('Descripcion')->nullable();
            $table->boolean('Estado')->default(true);
            $table->foreignId('Sub_Categoria_ID')
                ->nullable()
                ->constrained('categorias', 'ID_Categoria')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
