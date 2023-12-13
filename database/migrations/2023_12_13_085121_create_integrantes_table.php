<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('integrantes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("correo");

            $table->unsignedBigInteger("grupo");
            $table->foreign("grupo")->references("id")->on("grupos")->cascadeOnDelete();

            $table->unsignedBigInteger("usuario")->nullable();
            $table->foreign("usuario")->references("id")->on("users")->nullOnDelete();

            $table->boolean("confirmado")->default(false);
            $table->string("hash_confirmacion")->default(Hash::make(now()));

            $table->unsignedBigInteger("integrante_asignado")->nullable();
            $table->foreign("integrante_asignado")->references("id")->on("integrantes")->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrantes');
    }
};
