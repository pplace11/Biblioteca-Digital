<x-app-layout>
    {{-- Container principal da tela de listagem de editoras --}}
    <div class="p-6">
        {{-- Título da página --}}
        <h1 class="text-3xl font-bold mb-6">
            Editoras
        </h1>

        {{-- Botão para criar uma nova editora --}}
        <a href="{{ route('editoras.create') }}" class="btn btn-primary mb-4">
            Nova Editora
        </a>

        {{-- Formulário de filtros: pesquisa por nome e ordenação --}}
        <form method="GET" action="{{ route('editoras.index') }}" class="mb-6">
            <div class="flex flex-col gap-3">
                {{-- Linha de pesquisa por nome --}}
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        placeholder="Pesquisar por nome..."
                        value="{{ $search }}"
                        class="input input-bordered flex-1"
                    >
                    <button type="submit" class="btn btn-info">
                        Pesquisar
                    </button>

                    {{-- Mostra o botão de limpar quando houver termo de pesquisa ativo --}}
                    @if($search)
                        <a href="{{ route('editoras.index') }}" class="btn btn-outline">
                            Limpar
                        </a>
                    @endif
                </div>

                {{-- Linha de ordenação alfabética --}}
                <div class="flex gap-2">
                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Ordem:</span>
                        </label>
                        {{-- Envia o formulário automaticamente ao alterar a ordem --}}
                        <select name="sort_order" class="select select-bordered" onchange="this.form.submit()">
                            <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>A-Z (Crescente ↑)</option>
                            <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Z-A (Decrescente ↓)</option>
                        </select>
                    </div>

                    {{-- Exibe limpar para restaurar ordenação padrão quando necessário --}}
                    @if($sortOrder !== 'asc')
                        <div class="flex items-end">
                            <a href="{{ route('editoras.index') }}" class="btn btn-sm btn-outline">
                                Limpar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </form>

        {{-- Exibe tabela apenas quando houver editoras cadastradas --}}
        @if($editoras->count() > 0)
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Logótipo</th>
                    <th>Nome</th>
                    <th>Livros publicados</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                {{-- Percorre a lista de editoras para montar cada linha da tabela --}}
                @foreach ($editoras as $editora)
                    <tr>
                        {{-- Coluna do logótipo da editora --}}
                        <td>
                            @if ($editora->logotipo)
                                <img src="{{ asset($editora->logotipo) }}" class="w-16 h-16 object-contain">
                            @endif
                        </td>

                        {{-- Nome com link para página de detalhes da editora --}}
                        <td>
                            <a href="{{ route('editoras.show', $editora->id) }}" class="font-bold hover:underline">
                                {{ $editora->nome }}
                            </a>
                        </td>

                        {{-- Lista de livros publicados vinculados à editora --}}
                        <td>
                            @if ($editora->livros->count() > 0)
                                <div class="flex flex-wrap items-center gap-x-1 max-w-xl">
                                    @foreach ($editora->livros as $livro)
                                        {{-- Adiciona separador entre os nomes dos livros --}}
                                        @if (!$loop->first)
                                            <span class="text-gray-400 select-none">|</span>
                                        @endif
                                        <a href="{{ route('livros.show', $livro->id) }}"
                                            class="text-sm text-gray-800 hover:underline">
                                            {{ $livro->nome }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-sm text-gray-500">Sem livros vinculados</span>
                            @endif
                        </td>

                        {{-- Ações disponíveis para a editora atual --}}
                        <td>
                            <a href="{{ route('editoras.edit', $editora->id) }}" class="btn btn-primary btn-sm">
                                Editar
                            </a>

                            {{-- Formulário para apagar a editora --}}
                            <form action="{{ route('editoras.destroy', $editora->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-error btn-sm">
                                    Apagar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            {{-- Estado vazio quando não há editoras para os filtros aplicados --}}
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">Nenhuma editora encontrada.</p>
            </div>
        @endif
    </div>
</x-app-layout>
