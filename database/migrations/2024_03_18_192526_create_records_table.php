<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * campos de la tabla historial
     * fecha, incidencia, beneficiario id, voluntario id
     */
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->longText('incident')->charset('binary');
            $table->foreignId('beneficiary_id')->references('id')->on('beneficiaries')->onUpdate('cascade');
            $table->foreignId('volunteer_id')->references('id')->on('volunteers')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
