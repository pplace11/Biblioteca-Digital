<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** Adiciona campos para confirmação de receção e cálculo de dias decorridos. */
    public function up(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->timestamp('devolucao_solicitada_em')->nullable()->after('data_fim_prevista');
            $table->timestamp('data_recepcao_real')->nullable()->after('devolucao_solicitada_em');
            $table->unsignedInteger('dias_decorridos')->nullable()->after('data_recepcao_real');
            $table->foreignId('confirmado_por_admin_id')->nullable()->after('dias_decorridos')->constrained('users')->nullOnDelete();
        });
    }

    /** Remove os campos de confirmação de receção. */
    public function down(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('confirmado_por_admin_id');
            $table->dropColumn([
                'devolucao_solicitada_em',
                'data_recepcao_real',
                'dias_decorridos',
            ]);
        });
    }
};



