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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('ID_Movimientos');
            $table->enum('Tipo', ['Entrada', 'Salida']);
            $table->unsignedInteger('Cantidad');
            $table->dateTime('Fecha');
            $table->text('Observacion')->nullable();
            $table->foreignId('Producto_ID')->constrained('productos', 'ID_Producto');
            $table->foreignId('Almacen_ID')->constrained('almacenes', 'ID_Almacen');
            $table->foreignId('Users_ID')->constrained('users', 'ID_User');
            $table->foreignId('Proveedor_ID')
                ->nullable()
                ->constrained('proveedores', 'ID_Proveedor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
