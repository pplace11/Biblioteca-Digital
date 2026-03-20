<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Encripta numero_leitor em users e adiciona sequencial técnico para geração automática.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('numero_leitor_seq')->nullable()->unique()->after('numero_leitor');
        });

        $users = DB::table('users')
            ->select('id', 'numero_leitor', 'numero_leitor_seq')
            ->orderBy('id')
            ->get();

        $maxSeq = 0;

        foreach ($users as $user) {
            $valorAtual = (string) ($user->numero_leitor ?? '');

            if ($valorAtual === '') {
                continue;
            }

            try {
                $valorAtual = Crypt::decryptString($valorAtual);
            } catch (\Throwable $e) {
                // Valor ainda em texto simples, segue o fluxo normal.
            }

            $seq = (int) preg_replace('/\D+/', '', $valorAtual);
            if ($seq > $maxSeq) {
                $maxSeq = $seq;
            }
        }

        foreach ($users as $user) {
            $valorAtual = (string) ($user->numero_leitor ?? '');

            if ($valorAtual === '') {
                continue;
            }

            try {
                $valorPlano = Crypt::decryptString($valorAtual);
            } catch (\Throwable $e) {
                $valorPlano = $valorAtual;
            }

            $seq = (int) preg_replace('/\D+/', '', $valorPlano);
            if ($seq <= 0) {
                $seq = ++$maxSeq;
                $valorPlano = sprintf('L%06d', $seq);
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'numero_leitor' => Crypt::encryptString($valorPlano),
                    'numero_leitor_seq' => $seq,
                ]);
        }
    }

    /**
     * Reverte para valor em texto simples e remove o sequencial técnico.
     */
    public function down(): void
    {
        $users = DB::table('users')
            ->select('id', 'numero_leitor')
            ->whereNotNull('numero_leitor')
            ->orderBy('id')
            ->get();

        foreach ($users as $user) {
            $valor = (string) $user->numero_leitor;

            try {
                $valor = Crypt::decryptString($valor);
            } catch (\Throwable $e) {
                // Já está em texto simples.
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update(['numero_leitor' => $valor]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_numero_leitor_seq_unique');
            $table->dropColumn('numero_leitor_seq');
        });
    }
};



