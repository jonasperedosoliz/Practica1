<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            if (!Schema::hasColumn('categorias', 'estado')) {
                $table->boolean('estado')->default(1)->after('descripcion');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('categorias', 'estado')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->dropColumn('estado');
            });
        }
    }
};
