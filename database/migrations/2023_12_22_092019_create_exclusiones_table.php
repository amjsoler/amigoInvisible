<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exclusiones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("usuario_que_regala");
            $table->foreign("usuario_que_regala")->references("id")->on("integrantes")->cascadeOnDelete();

            $table->unsignedBigInteger("usuario_excluido");
            $table->foreign("usuario_excluido")->references("id")->on("integrantes")->cascadeOnDelete();

            $table->unsignedBigInteger("grupo");
            $table->foreign("grupo")->references("id")->on("grupos")->cascadeOnDelete();

            $table->unique(["usuario_que_regala", "usuario_excluido"]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exclusiones');
    }
};
