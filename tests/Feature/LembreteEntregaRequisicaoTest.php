<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Livro;
use App\Models\Editora;
use App\Models\Requisicao;
use App\Notifications\LembreteEntregaRequisicaoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LembreteEntregaRequisicaoTest extends TestCase
{
    public function test_lembrete_enviado_dia_anterior_entrega()
    {
        Notification::fake();
        $user = User::factory()->create();
        $editora = Editora::create(['nome' => 'TesteEditora']);
        $livro = Livro::create([
            'isbn' => 'isbn-lembrete-001',
            'nome' => 'Livro Lembrete',
            'editora_id' => $editora->id,
            'bibliografia' => 'Teste lembrete',
            'preco' => 10.00,
        ]);
        $requisicao = Requisicao::create([
            'user_id' => $user->id,
            'livro_id' => $livro->id,
            'data_fim_prevista' => Carbon::tomorrow()->setHour(10),
        ]);

        // Simula execução do lembrete no dia anterior
        $this->travelTo(Carbon::tomorrow()->subDay()->setHour(8));
        $user->notify(new LembreteEntregaRequisicaoNotification($requisicao, ['mail']));

        Notification::assertSentTo(
            $user,
            LembreteEntregaRequisicaoNotification::class,
            function ($notification, $channels) use ($requisicao) {
                return in_array('mail', $channels)
                    && $notification->requisicao->id === $requisicao->id;
            }
        );
    }
}
