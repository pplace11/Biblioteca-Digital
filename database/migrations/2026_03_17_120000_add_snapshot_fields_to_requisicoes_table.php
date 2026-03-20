<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** Adiciona snapshot do cidadão e data prevista de fim às requisições existentes e futuras. */
    public function up(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->string('cidadao_nome')->nullable()->after('livro_id');
            $table->string('cidadao_email')->nullable()->after('cidadao_nome');
            $table->string('cidadao_foto_path', 2048)->nullable()->after('cidadao_email');
            $table->timestamp('data_fim_prevista')->nullable()->after('updated_at');
        });

        $users = DB::table('users')
            ->select('id', 'name', 'email', 'profile_photo_path')
            ->get()
            ->keyBy('id');

        DB::table('requisicoes')
            ->select('id', 'user_id', 'created_at')
            ->orderBy('id')
            ->get()
            ->each(function ($requisicao) use ($users) {
                $user = $users->get($requisicao->user_id);

                DB::table('requisicoes')
                    ->where('id', $requisicao->id)
                    ->update([
                        'cidadao_nome' => $user?->name,
                        'cidadao_email' => $user?->email,
                        'cidadao_foto_path' => $user?->profile_photo_path,
                        'data_fim_prevista' => $requisicao->created_at
                            ? Carbon::parse($requisicao->created_at)->addDays(5)
                            : null,
                    ]);
            });
    }

    /** Remove os campos de snapshot do cidadão e a data prevista de fim. */
    public function down(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->dropColumn([
                'cidadao_nome',
                'cidadao_email',
                'cidadao_foto_path',
                'data_fim_prevista',
            ]);
        });
    }
};



