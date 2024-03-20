<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * campos de la tabla derivaciones.
     * motivo, observaciones, beneficiario id, voluntario id, colaborador id
     */
    public function up(): void
    {
        Schema::create('derivations', function (Blueprint $table) {
            $table->id();
            $table->string('reason')->nullable();
            $table->string('observation')->nullable();
            $table->foreignId('beneficiary_id')->references('id')->on('beneficiaries')->onUpdate('cascade');
            $table->foreignId('volunteer_id')->references('id')->on('volunteers')->onUpdate('cascade');
            $table->foreignId('collaborator_id')->references('id')->on('collaborators')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derivations');
    }
};
