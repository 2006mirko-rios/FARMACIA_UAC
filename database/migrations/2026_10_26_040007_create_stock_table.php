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
        Schema::create('stock', function (Blueprint $table) {
            $table->id('ID_Stock');
            $table->unsignedInteger('Stock_Minimo')->default(0);
            $table->unsignedInteger('Stock_Maximo')->default(0);
            $table->unsignedInteger('Cantidad')->default(0);
            $table->foreignId('Producto_ID')->constrained('productos', 'ID_Producto');
            $table->foreignId('Almacen_ID')->constrained('almacenes', 'ID_Almacen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
