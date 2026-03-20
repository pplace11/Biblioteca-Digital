<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** Cria a tabela de requisicoes de livros com chaves estrangeiras e constraint de unicidade. */
    public function up(): void
    {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('livro_id')->constrained('livros')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'livro_id']);
        });
    }

    /** Remove a tabela de requisicoes. */
    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
    }
};



