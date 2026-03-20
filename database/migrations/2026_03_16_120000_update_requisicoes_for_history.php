<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** Adiciona soft deletes e remove a constraint de unicidade para permitir historico de requisicoes. */
    public function up(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->softDeletes();
            $table->dropUnique(['user_id', 'livro_id']);
        });
    }

    /** Reverte a adicao de soft deletes e restaura a constraint de unicidade. */
    public function down(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->unique(['user_id', 'livro_id']);
        });
    }
};



