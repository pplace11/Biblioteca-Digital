<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Adiciona numero sequencial das requisicoes e preenche registos existentes.
     */
    public function up(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->unsignedBigInteger('numero_requisicao_seq')->nullable()->unique()->after('id');
        });

        $requisicoes = DB::table('requisicoes')
            ->select('id')
            ->orderBy('id')
            ->get();

        $seq = 0;

        foreach ($requisicoes as $requisicao) {
            $seq++;

            DB::table('requisicoes')
                ->where('id', $requisicao->id)
                ->update(['numero_requisicao_seq' => $seq]);
        }
    }

    /**
     * Remove o numero sequencial das requisicoes.
     */
    public function down(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->dropUnique('requisicoes_numero_requisicao_seq_unique');
            $table->dropColumn('numero_requisicao_seq');
        });
    }
};



