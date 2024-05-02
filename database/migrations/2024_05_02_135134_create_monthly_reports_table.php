<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * campos de la tabla reporte mensual:
     * id, mes, año, colecta, donativo por banco, recibos de socios, recibos de caritas, transferencia a caritas, alimentacion, recibo de suministros, banco, vivienda, otras intervenciones, salud, transeuntes, mensaje, created_at, updated_at
     */
    public function up(): void
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->integer('year');
            $table->decimal('collection', 10, 2)->nullable();
            $table->decimal('donation_by_bank', 10, 2)->nullable();
            $table->decimal('membership_receipts', 10, 2)->nullable();
            $table->decimal('charity_receipts', 10, 2)->nullable();
            $table->decimal('charity_transfer', 10, 2)->nullable();
            $table->decimal('food', 10, 2)->nullable();
            $table->decimal('supplies_receipt', 10, 2)->nullable();
            $table->decimal('bank', 10, 2)->nullable();
            $table->decimal('housing', 10, 2)->nullable();
            $table->decimal('other_interventions', 10, 2)->nullable();
            $table->decimal('health', 10, 2)->nullable();
            $table->decimal('guests', 10, 2)->nullable();
            $table->longText('message')->charset('binary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
