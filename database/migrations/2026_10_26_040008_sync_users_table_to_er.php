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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'ID_User');
            $table->renameColumn('name', 'Nombre');
            $table->renameColumn('email', 'Email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('Apellido')->after('Nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('Apellido');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('ID_User', 'id');
            $table->renameColumn('Nombre', 'name');
            $table->renameColumn('Email', 'email');
        });
    }
};
