<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrations.
     */
    public function up(): void
    {
        Schema::table('autors', function (Blueprint $table) {
            $table->text('bibliografia')->nullable()->after('foto');
        });
    }

    /**
     * Reverte as migrations.
     */
    public function down(): void
    {
        Schema::table('autors', function (Blueprint $table) {
            $table->dropColumn('bibliografia');
        });
    }
};
