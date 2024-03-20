<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * campos de la tabla families
     * nombre, dni, fecha de vencimiento, nacionalidad, fecha de nacimiento, parentesco, telefono, email
     * educacion, fecha emision ivl, fecha alta ivl, fecha baja ivl, fecha emision cdp, estado cdp, monto cdp
     * fecha emision sepe, fecha renovacion sepe, estado sepe, monto sepe, fecha emision rmv, estado rmv, monto rmv
     * fecha emision remisa, estado remisa, monto remisa, idbeneficiario
     */
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            //datos generales
            $table->string('name');
            $table->string('dni')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('nationality')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('relationship')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('education')->nullable();
            //ivl
            $table->date('ivl_emission_date')->nullable();
            $table->date('ivl_alta_date')->nullable();
            $table->date('ivl_baja_date')->nullable();
            //cdp
            $table->date('cdp_emission_date')->nullable();
            $table->boolean('cdp_state')->nullable();
            $table->decimal('cdp_amount', 10, 2)->nullable();
            //sepe
            $table->date('sepe_emission_date')->nullable();
            $table->boolean('sepe_state')->nullable();
            $table->decimal('sepe_amount', 10, 2)->nullable();
            //rmv
            $table->date('rmv_emission_date')->nullable();
            $table->boolean('rmv_state')->nullable();
            $table->decimal('rmv_amount', 10, 2)->nullable();
            //remisa
            $table->date('remisa_emission_date')->nullable();
            $table->boolean('remisa_state')->nullable();
            $table->decimal('remisa_amount', 10, 2)->nullable();
            //relacion con familiar
            $table->foreignId('beneficiary_id')->references('id')->on('beneficiaries')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
