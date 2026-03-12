<x-app-layout>
    {{-- Container principal da página de detalhes do livro --}}
    <div class="p-6 max-w-5xl mx-auto">
        {{-- Botão para voltar à listagem de livros --}}
        <div class="mb-6 text-left">
            <a href="{{ route('livros.index') }}" class="btn btn-outline text-xl px-4 py-2 min-h-0 h-auto leading-none" aria-label="Voltar aos Livros" title="Voltar">&larr;</a>
        </div>

        {{-- Cabeçalho com nome do livro --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">{{ $livro->nome }}</h1>
        </div>

        {{-- Card com dados principais do livro --}}
        <div class="card bg-base-100 shadow mb-8">
            <div class="card-body grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Coluna da capa (ou placeholder quando não existir imagem) --}}
                <div>
                    @if ($livro->imagem_capa)
                        <img src="{{ asset($livro->imagem_capa) }}" alt="Capa de {{ $livro->nome }}"
                            class="w-full max-w-52 object-cover rounded-lg">
                    @else
                        <div
                            class="w-full max-w-52 h-64 bg-base-200 rounded-lg flex items-center justify-center text-sm opacity-70">
                            Sem capa
                        </div>
                    @endif
                </div>

                {{-- Coluna com metadados do livro --}}
                <div class="md:col-span-2 space-y-2">
                    <p><span class="font-semibold">Editora:</span> {{ $livro->editora?->nome ?? 'Sem editora' }}</p>
                    <p><span class="font-semibold">ISBN:</span> {{ $livro->isbn }}</p>
                    <p><span class="font-semibold">Preco:</span> EUR {{ number_format($livro->preco, 2, ',', '.') }}</p>
                    <div>
                        <p class="font-semibold mb-1">Bibliografia</p>
                        <p class="text-sm leading-relaxed">{{ $livro->bibliografia }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Seção inferior com relacionamentos: autores e editora --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-2xl font-semibold mb-4">Autor</h2>

                {{-- Lista de autores vinculados ao livro --}}
                @if ($livro->autores->count() > 0)
                    <div class="flex flex-col gap-3">
                        @foreach ($livro->autores as $autor)
                            {{-- Card clicável do autor --}}
                            <a href="{{ route('autores.show', $autor->id) }}"
                                class="card bg-base-100 shadow hover:shadow-md transition-shadow">
                                <div class="card-body flex-row items-center gap-3 p-4">
                                    {{-- Foto do autor ou inicial do nome quando não houver foto --}}
                                    @if ($autor->foto)
                                        <img src="{{ asset($autor->foto) }}" alt="Foto de {{ $autor->nome }}"
                                            class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-full bg-base-200 flex items-center justify-center text-sm font-semibold">
                                            {{ strtoupper(substr($autor->nome, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="font-semibold text-black">{{ $autor->nome }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- Estado vazio quando não há autores vinculados --}}
                    <div class="alert">
                        <span>Este livro ainda nao possui autores vinculados.</span>
                    </div>
                @endif
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-4">Editora</h2>

                {{-- Card da editora vinculada ao livro --}}
                @if ($livro->editora)
                    <a href="{{ route('editoras.show', $livro->editora->id) }}"
                        class="card bg-base-100 shadow hover:shadow-md transition-shadow">
                        <div class="card-body flex-row items-center gap-3 p-4">
                            {{-- Logotipo da editora ou inicial do nome quando não houver imagem --}}
                            @if ($livro->editora->logotipo)
                                <img src="{{ asset($livro->editora->logotipo) }}"
                                    alt="Logo de {{ $livro->editora->nome }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div
                                    class="w-12 h-12 rounded-full bg-base-200 flex items-center justify-center text-sm font-semibold">
                                    {{ strtoupper(substr($livro->editora->nome, 0, 1)) }}
                                </div>
                            @endif
                            <span class="font-semibold text-black">{{ $livro->editora->nome }}</span>
                        </div>
                    </a>
                @else
                    {{-- Estado vazio quando não há editora vinculada --}}
                    <div class="alert">
                        <span>Este livro ainda não possui editora vinculada.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
