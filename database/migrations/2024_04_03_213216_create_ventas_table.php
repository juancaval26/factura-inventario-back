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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->integer('cantidad');
            $table->string('codigo');
            $table->text('descripcion')->nullable();
            $table->integer('precio');
            $table->string('vendedor', 50);
            $table->date('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
