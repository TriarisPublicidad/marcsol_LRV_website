<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug');
            $table->string('direccion');
            $table->string('ciudad')->default('Quevedo');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->decimal('mapa_lat', 10, 7)->nullable();
            $table->decimal('mapa_lng', 10, 7)->nullable();
            $table->text('horarios')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['slug', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};

