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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->text("descripcion")->nullable();
            $table->integer("precio_minimo")->nullable();
            $table->integer("precio_maximo")->nullable();
            $table->string("tematica_regalos")->nullable();
            $table->timestamp("fecha_autoasignacion")->nullable();

            $table->unsignedBigInteger("administrador");
            $table->foreign("administrador")->references("id")->on("users");

            $table->string("hash")->default(str_replace("/", "", Hash::make(now())));
            $table->boolean("integrantes_asignados")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
