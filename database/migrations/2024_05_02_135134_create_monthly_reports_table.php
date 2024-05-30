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
            $table->integer('month');
            $table->integer('year');
            //ingresos
            $table->decimal('collection', 10, 2)->nullable();
            $table->decimal('parroquial_receipt', 10, 2)->nullable();
            $table->decimal('bank_donation', 10, 2)->nullable();
            $table->decimal('volunteer_campaign_donation', 10, 2)->nullable();
            $table->decimal('diosesano_receipt', 10, 2)->nullable();
            $table->decimal('diosesano_donation', 10, 2)->nullable();
            $table->decimal('other_donation', 10, 2)->nullable();
            $table->decimal('special_donation', 10, 2)->nullable();
            //gastos
            $table->decimal('transfer_collection', 10, 2)->nullable();
            $table->decimal('transfer_membership', 10, 2)->nullable();
            $table->decimal('transfer_campaign', 10, 2)->nullable();
            $table->decimal('transfer_other', 10, 2)->nullable();
            $table->decimal('transfer_arciprestal', 10, 2)->nullable();
            $table->decimal('health', 10, 2)->nullable();
            $table->decimal('housing', 10, 2)->nullable();
            $table->decimal('food', 10, 2)->nullable();
            $table->decimal('supplies_receipt', 10, 2)->nullable();
            $table->decimal('other_intervention', 10, 2)->nullable();
            $table->decimal('parish_project', 10, 2)->nullable();
            $table->decimal('general_expense', 10, 2)->nullable();
            $table->decimal('other_entity', 10, 2)->nullable();
            $table->decimal('campaign_volunteers', 10, 2)->nullable();
            $table->decimal('campaign_local_emergency', 10, 2)->nullable();
            $table->decimal('campaign_international_emergency', 10, 2)->nullable();
            $table->decimal('development_cooperation', 10, 2)->nullable();
            //notas
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
