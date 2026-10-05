<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->longText('valor')->nullable();
            $table->string('grupo')->default('branding'); // branding, tracking, seo_global
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['clave', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
