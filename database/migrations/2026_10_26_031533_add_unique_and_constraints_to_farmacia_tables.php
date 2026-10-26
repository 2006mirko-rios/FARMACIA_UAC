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
        $unsignedColumns = [
            'productos' => ['stock_minimo' => null],
            'stock_almacen' => ['stock' => 0],
            'movimientos' => ['cantidad' => null],
        ];

        foreach ($unsignedColumns as $tableName => $columns) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            foreach ($columns as $column => $default) {
                if (! Schema::hasColumn($tableName, $column)) {
                    continue;
                }

                Schema::table($tableName, function (Blueprint $table) use ($column, $default) {
                    $definition = $table->unsignedInteger($column);

                    if ($default !== null) {
                        $definition->default($default);
                    }

                    $definition->change();
                });
            }
        }

        $foreignKeys = [
            'productos' => [
                ['categoria_id', 'categorias'],
            ],
            'stock_almacen' => [
                ['producto_id', 'productos'],
                ['almacen_id', 'almacenes'],
            ],
            'movimientos' => [
                ['producto_id', 'productos'],
                ['almacen_id', 'almacenes'],
                ['proveedor_id', 'proveedores'],
                ['user_id', 'users'],
            ],
        ];

        foreach ($foreignKeys as $tableName => $constraints) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            foreach ($constraints as [$column, $foreignTable]) {
                if (! Schema::hasColumn($tableName, $column)) {
                    continue;
                }

                if (Schema::hasForeignKey($tableName, [$column])) {
                    continue;
                }

                Schema::table($tableName, function (Blueprint $table) use ($column, $foreignTable) {
                    $table->foreign($column)
                        ->references('id')
                        ->on($foreignTable)
                        ->restrictOnDelete();
                });
            }
        }

        $uniqueIndexes = [
            ['productos', ['codigo']],
            ['proveedores', ['ruc']],
            ['stock_almacen', ['producto_id', 'almacen_id']],
        ];

        foreach ($uniqueIndexes as [$tableName, $columns]) {
            if (! Schema::hasTable($tableName) || Schema::hasIndex($tableName, $columns, 'unique')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($columns) {
                $table->unique($columns);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (
            Schema::hasTable('stock_almacen')
            && Schema::hasIndex('stock_almacen', 'stock_almacen_producto_id_almacen_id_unique')
        ) {
            Schema::table('stock_almacen', function (Blueprint $table) {
                $table->dropUnique('stock_almacen_producto_id_almacen_id_unique');
            });
        }
    }
};
