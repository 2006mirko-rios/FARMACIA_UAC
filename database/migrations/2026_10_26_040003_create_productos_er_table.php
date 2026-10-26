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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('ID_Producto');
            $table->string('Nombre');
            $table->string('Codigo', 50)->unique();
            $table->string('Serie', 100)->nullable();
            $table->decimal('Peso', 8, 2)->nullable();
            $table->boolean('Estado')->default(true);
            $table->foreignId('Categoria_ID')->constrained('categorias', 'ID_Categoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
