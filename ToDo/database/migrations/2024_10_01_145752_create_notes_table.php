<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60);
            $table->text('description')->max(600);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->string('img_uri',255)->nullable();
            $table->date('fecha_vencimiento')->nullable();

            //Referencia a la clave foranea, se gestiona metodo de actualizado y eliminación para que todas cambien o se eliminen si le pasa algo al usuario.
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
