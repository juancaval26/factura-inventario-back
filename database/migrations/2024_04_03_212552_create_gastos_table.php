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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('articulo', 20);
            $table->integer('valor');
            $table->string('motivo_gasto', 30);
            $table->date('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
