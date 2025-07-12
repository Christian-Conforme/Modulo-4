<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculo_sucursal', function (Blueprint $table) {
            $table->id('id_relacion');
            $table->unsignedBigInteger('vehiculo_id');
            $table->unsignedBigInteger('sucursal_id');
            $table->date('fecha_ingreso')->nullable();
            $table->timestamps();

            $table->foreign('vehiculo_id')->references('id_vehiculo')->on('vehiculo')->onDelete('cascade');
            $table->foreign('sucursal_id')->references('id_sucursal')->on('sucursal')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculo_sucursal');
    }
};