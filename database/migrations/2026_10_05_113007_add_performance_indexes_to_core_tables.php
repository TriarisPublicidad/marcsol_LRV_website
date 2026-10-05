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
        Schema::table('promotions', function (Blueprint $table) {
            $table->index('status');
            $table->index('es_promocion_del_dia');
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('status');
            $table->index('fecha_evento');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->index(['ubicacion', 'status', 'orden']);
        });

        Schema::table('redirects_301', function (Blueprint $table) {
            $table->index('status');
            $table->index('url_origen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['es_promocion_del_dia']);
            $table->dropIndex(['fecha_inicio']);
            $table->dropIndex(['fecha_fin']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['fecha_evento']);
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['ubicacion', 'status', 'orden']);
        });

        Schema::table('redirects_301', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['url_origen']);
        });
    }
};
