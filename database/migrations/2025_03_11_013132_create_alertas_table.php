<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained('sensores')->onDelete('cascade');
            $table->string('tipo_alerta', 50);
            $table->text('descripcion');
            $table->timestamp('fecha_hora')->useCurrent();
            $table->enum('estado', ['activa', 'resuelta'])->default('activa');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('alertas');
    }
};
