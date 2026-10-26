<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('movimientos');
        Schema::dropIfExists('stock_almacen');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('almacenes');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('categorias');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
