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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 40);
            $table->string('negocio', 40)->nullable();
            $table->string('direccion',30)->nullable();
            $table->string('ciudad',30);
            $table->string('departamento',30);
            $table->string('telefono',20)->nullable();
            $table->string('nit', 15)->nullable();
            $table->tinyInteger('estado')->nullable();
            $table->string('correo',100)->nullable();
            $table->date('fecha');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
