<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * campos de la tabla colaboradores
     * nombre, direccion, website, imagen, persona responsable, cargo email, telefono,
     * persona responsable 2, cargo 2,email 2, telefono 2, notas
     */
    public function up(): void
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->string('responsable')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('responsable2')->nullable();
            $table->string('position2')->nullable();
            $table->string('email2')->nullable();
            $table->string('phone2')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
