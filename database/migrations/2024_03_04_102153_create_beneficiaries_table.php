<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * id, nombre, expediente, dni, fecha de vencimiento, nacionalidad, fecha de nacimiento, direccion, telefono, email, educacion, 
     * tipo de vivienda, ingresos, luz, agua, alquiler, comunidad, otros
     * libro de familia, contrato de alquiler, fecha de emision de padron municipal, nombre asistente social, 
     * fecha emision ivl, fecha alta ivl, fecha baja ivl, 
     * fecha emision cdp, estado cdp, monto cdp
     * fecha emision sepe, estado sepe, monto sepe, 
     * fecha emision rmv, estado rmv, monto rmv, 
     * fecha emision remisa, estado remisa, monto remisa, 
     * estado, timestamp
    */
    public function up(): void
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            //datos personales
            $table->id();
            $table->string('name');
            $table->string('expedient')->nullable();
            $table->string('dni')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('nationality')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('education')->nullable();
            //datos socioeconomicos
            $table->string('housing_type')->nullable();
            $table->decimal('incomes', 10, 2)->nullable();
            $table->decimal('light', 10, 2)->nullable();
            $table->decimal('water', 10, 2)->nullable();
            $table->decimal('rent', 10, 2)->nullable();
            $table->decimal('community', 10, 2)->nullable();
            $table->decimal('others', 10, 2)->nullable();
            //documentos generales
            $table->boolean('family_book')->nullable();
            $table->boolean('rent_contract')->nullable();
            $table->date('census_emission_date')->nullable();
            $table->string('social_assistance_name')->nullable();
            //documentos ivl
            $table->date('ivl_emission_date')->nullable();
            $table->date('ivl_alta_date')->nullable();
            $table->date('ivl_baja_date')->nullable();
            //documentos cdp
            $table->date('cdp_emission_date')->nullable();
            $table->boolean('cdp_state')->nullable();
            $table->decimal('cdp_amount', 10, 2)->nullable();
            //documentos sepe
            $table->date('sepe_emission_date')->nullable();
            $table->boolean('sepe_state')->nullable();
            $table->decimal('sepe_amount', 10, 2)->nullable();
            //documentos rmv
            $table->date('rmv_emission_date')->nullable();
            $table->boolean('rmv_state')->nullable();
            $table->decimal('rmv_amount', 10, 2)->nullable();
            //documentos remisa
            $table->date('remisa_emission_date')->nullable();
            $table->boolean('remisa_state')->nullable();
            $table->decimal('remisa_amount', 10, 2)->nullable();
            //estado
            $table->string('state')->nullable();
            //relaciones
            $table->foreignId('volunteer_id')->constrained('volunteers')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
