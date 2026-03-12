<x-app-layout>
    {{-- Container principal da tela de listagem de livros --}}
    <div class="p-6">
        {{-- Título da página --}}
        <h1 class="text-3xl font-bold mb-6">
            Livros
        </h1>

        {{-- Ações rápidas da listagem: criar livro e exportar dados --}}
        <div class="flex gap-4 mb-4">
            <a href="{{ route('livros.create') }}" class="btn btn-primary">
                Novo Livro
            </a>
            <a href="{{ route('livros.export') }}" class="btn btn-success">
                Exportar Excel
            </a>
        </div>

        {{-- Formulário de filtros: pesquisa e ordenação --}}
        <form method="GET" action="{{ route('livros.index') }}" class="mb-6">
            <div class="flex flex-col gap-3">
                {{-- Linha de busca por nome, autor ou editora --}}
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Pesquisar por nome, autor ou editora..."
                        value="{{ $search }}" class="input input-bordered flex-1">
                    <button type="submit" class="btn btn-info">
                        Pesquisar
                    </button>

                    {{-- Mostra botão para limpar a pesquisa quando existir termo ativo --}}
                    @if ($search)
                        <a href="{{ route('livros.index') }}" class="btn btn-outline">
                            Limpar
                        </a>
                    @endif
                </div>

                {{-- Linha de ordenação por campo e direção --}}
                <div class="flex gap-2">
                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Ordenar por:</span>
                        </label>
                        {{-- Envia o formulário automaticamente ao trocar o campo de ordenação --}}
                        <select name="sort_by" class="select select-bordered" onchange="this.form.submit()">
                            <option value="nome" {{ $sortBy === 'nome' ? 'selected' : '' }}>Nome do Livro (A-Z)
                            </option>
                            <option value="editora" {{ $sortBy === 'editora' ? 'selected' : '' }}>Editora (A-Z)</option>
                            <option value="autor" {{ $sortBy === 'autor' ? 'selected' : '' }}>Autor (A-Z)</option>
                        </select>
                    </div>
                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Ordem:</span>
                        </label>
                        {{-- Envia o formulário automaticamente ao trocar a direção da ordenação --}}
                        <select name="sort_order" class="select select-bordered" onchange="this.form.submit()">
                            <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Crescente ↑</option>
                            <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Decrescente ↓</option>
                        </select>
                    </div>
                </div>

                {{-- Exibe opção para restaurar ordenação padrão quando filtros de ordenação estiverem ativos --}}
                @if ($sortBy !== 'nome' || $sortOrder !== 'asc')
                    <a href="{{ route('livros.index') }}" class="btn btn-sm btn-outline">
                        Limpar Ordenação
                    </a>
                @endif
            </div>
        </form>

        {{-- Exibe tabela apenas quando houver livros cadastrados --}}
        @if ($livros->count() > 0)
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Capa</th>
                        <th>Nome</th>
                        <th>Autores</th>
                        <th>Editora</th>
                        <th>ISBN</th>
                        <th>Bibliografia</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Percorre a coleção de livros para renderizar cada linha --}}
                    @foreach ($livros as $livro)
                        <tr>
                            {{-- Capa do livro, quando existir imagem cadastrada --}}
                            <td>
                                @if ($livro->imagem_capa)
                                    <img src="{{ asset($livro->imagem_capa) }}" class="w-16 h-20 object-cover">
                                @endif
                            </td>

                            {{-- Nome do livro com link para página de detalhes --}}
                            <td>
                                <a href="{{ route('livros.show', $livro->id) }}"
                                    class="text-black font-semibold hover:underline">
                                    {{ $livro->nome }}
                                </a>
                            </td>

                            {{-- Lista de autores vinculados ao livro --}}
                            <td>
                                <div class="flex flex-wrap items-center gap-x-1">
                                    @foreach ($livro->autores as $autor)
                                        {{-- Adiciona separador entre os autores, exceto antes do primeiro --}}
                                        @if (!$loop->first)
                                            <span class="text-gray-400 select-none">|</span>
                                        @endif
                                        <a href="{{ route('autores.show', $autor->id) }}"
                                            class="text-sm text-gray-800 hover:underline">
                                            {{ $autor->nome }}
                                        </a>
                                    @endforeach
                                </div>
                            </td>

                            {{-- Nome da editora do livro --}}
                            <td>{{ $livro->editora->nome }}</td>

                            {{-- ISBN do livro --}}
                            <td class="text-sm">{{ $livro->isbn }}</td>

                            {{-- Bibliografia truncada com conteúdo completo disponível no tooltip --}}
                            <td class="text-sm max-w-xs truncate" title="{{ $livro->bibliografia }}">
                                {{ $livro->bibliografia }}</td>

                            {{-- Preço formatado para padrão monetário local --}}
                            <td>€ {{ number_format($livro->preco, 2, ',', '.') }}</td>

                            {{-- Ações disponíveis para cada livro --}}
                            <td>
                                <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-primary btn-sm">
                                    Editar
                                </a>

                                {{-- Formulário para exclusão do livro --}}
                                <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" class="inline">
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
            {{-- Estado vazio quando nenhum livro é encontrado --}}
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">Nenhum livro encontrado.</p>
            </div>
        @endif
    </div>
</x-app-layout>
