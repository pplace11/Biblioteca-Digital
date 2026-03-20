<?php



use App\Models\Editora;
use App\Models\Livro;
use App\Models\Requisicao;
use App\Models\User;

it('permite requisitar um livro quando ele esta disponivel', function () {
    $user = User::factory()->create();
    $editora = Editora::create([
        'nome' => 'Penguin',
    ]);
    $livro = Livro::create([
        'isbn' => 'isbn-disponivel-001',
        'nome' => 'Livro Disponivel',
        'editora_id' => $editora->id,
        'bibliografia' => 'Teste de disponibilidade',
        'preco' => 19.90,
    ]);

    $response = $this->actingAs($user)->post(route('livros.requisitar', $livro));

    $response->assertRedirect(route('livros.index'));
    $response->assertSessionHas('success', 'Livro requisitado com sucesso.');

    $this->assertDatabaseHas('requisicoes', [
        'user_id' => $user->id,
        'livro_id' => $livro->id,
    ]);
});

it('impede requisitar um livro quando ele ja esta requisitado por outro utilizador', function () {
    $userAtual = User::factory()->create();
    $outroUser = User::factory()->create();
    $editora = Editora::create([
        'nome' => 'Rocco',
    ]);
    $livro = Livro::create([
        'isbn' => 'isbn-indisponivel-001',
        'nome' => 'Livro Indisponivel',
        'editora_id' => $editora->id,
        'bibliografia' => 'Teste de indisponibilidade',
        'preco' => 29.90,
    ]);

    Requisicao::create([
        'user_id' => $outroUser->id,
        'livro_id' => $livro->id,
    ]);

    $response = $this->actingAs($userAtual)->post(route('livros.requisitar', $livro));

    $response->assertRedirect(route('livros.show', $livro));
    $response->assertSessionHas('info', 'Livro indisponível no momento.');

    $this->assertDatabaseMissing('requisicoes', [
        'user_id' => $userAtual->id,
        'livro_id' => $livro->id,
    ]);

    expect(Requisicao::count())->toBe(1);
});

it('nao cria uma segunda requisicao quando o mesmo utilizador tenta requisitar o mesmo livro novamente', function () {
    $user = User::factory()->create();
    $editora = Editora::create([
        'nome' => 'Companhia das Letras',
    ]);
    $livro = Livro::create([
        'isbn' => 'isbn-repetido-001',
        'nome' => 'Livro Repetido',
        'editora_id' => $editora->id,
        'bibliografia' => 'Teste de duplicidade',
        'preco' => 39.90,
    ]);

    Requisicao::create([
        'user_id' => $user->id,
        'livro_id' => $livro->id,
    ]);

    $response = $this->actingAs($user)->post(route('livros.requisitar', $livro));

    $response->assertRedirect(route('livros.index'));
    $response->assertSessionHas('info', 'Já requisitou este livro.');

    expect(Requisicao::count())->toBe(1);
});

