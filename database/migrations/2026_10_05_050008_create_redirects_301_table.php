<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirects_301', function (Blueprint $table) {
            $table->id();
            $table->string('url_origen');
            $table->string('url_destino');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('hits')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['url_origen', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects_301');
    }
};
