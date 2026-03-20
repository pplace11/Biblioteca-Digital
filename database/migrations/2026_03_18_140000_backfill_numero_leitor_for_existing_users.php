<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Preenche número de leitor em utilizadores já existentes que ainda não tenham número.
     * Também atualiza snapshot de requisições sem número.
     */
    public function up(): void
    {
        $maxSequencial = DB::table('users')
            ->whereNotNull('numero_leitor')
            ->pluck('numero_leitor')
            ->map(function ($numero) {
                return (int) preg_replace('/\D+/', '', (string) $numero);
            })
            ->max() ?? 0;

        $proximoSequencial = $maxSequencial + 1;

        DB::table('users')
            ->whereNull('numero_leitor')
            ->orderBy('id')
            ->select('id')
            ->get()
            ->each(function ($user) use (&$proximoSequencial) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'numero_leitor' => sprintf('L%06d', $proximoSequencial++),
                    ]);
            });

        DB::table('requisicoes')
            ->leftJoin('users', 'users.id', '=', 'requisicoes.user_id')
            ->whereNull('requisicoes.cidadao_numero_leitor')
            ->whereNotNull('users.numero_leitor')
            ->select('requisicoes.id', 'users.numero_leitor')
            ->orderBy('requisicoes.id')
            ->get()
            ->each(function ($requisicao) {
                DB::table('requisicoes')
                    ->where('id', $requisicao->id)
                    ->update([
                        'cidadao_numero_leitor' => $requisicao->numero_leitor,
                    ]);
            });
    }

    public function down(): void
    {
        // Migração de dados sem reversão segura.
    }
};



