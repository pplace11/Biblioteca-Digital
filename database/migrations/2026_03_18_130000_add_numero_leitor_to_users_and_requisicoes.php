<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** Adiciona número de leitor ao utilizador e snapshot nas requisições. */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('numero_leitor', 20)->nullable()->unique()->after('email');
        });

        $maxSequencial = DB::table('users')
            ->whereNotNull('numero_leitor')
            ->pluck('numero_leitor')
            ->map(function ($numero) {
                return (int) preg_replace('/\D+/', '', (string) $numero);
            })
            ->max() ?? 0;

        $proximoSequencial = $maxSequencial + 1;

        DB::table('users')
            ->where('role', 'cidadao')
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

        Schema::table('requisicoes', function (Blueprint $table) {
            $table->string('cidadao_numero_leitor', 20)->nullable()->after('cidadao_email');
        });

        DB::table('requisicoes')
            ->leftJoin('users', 'users.id', '=', 'requisicoes.user_id')
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

    /** Remove os campos de número de leitor. */
    public function down(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->dropColumn('cidadao_numero_leitor');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_numero_leitor_unique');
            $table->dropColumn('numero_leitor');
        });
    }
};



