<x-app-layout>
    {{-- Container principal da listagem de autores --}}
    <div class="p-6">
        {{-- Título da página --}}
        <h1 class="text-3xl font-bold mb-6">
            Autores
        </h1>

        {{-- Ação para abrir o formulário de cadastro de um novo autor --}}
        <a href="{{ route('autores.create') }}" class="btn btn-primary mb-4">
            Novo Autor
        </a>

        {{-- Formulário de filtros: pesquisa por nome e ordenação --}}
        <form method="GET" action="{{ route('autores.index') }}" class="mb-6">
            <div class="flex flex-col gap-3">
                {{-- Linha de busca por nome --}}
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Pesquisar por nome..." value="{{ $search }}"
                        class="input input-bordered flex-1">
                    <button type="submit" class="btn btn-info">
                        Pesquisar
                    </button>

                    {{-- Exibe botão para limpar o termo de pesquisa quando houver filtro ativo --}}
                    @if ($search)
                        <a href="{{ route('autores.index') }}" class="btn btn-outline">
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
                        {{-- Envia automaticamente o formulário ao mudar a ordem --}}
                        <select name="sort_order" class="select select-bordered" onchange="this.form.submit()">
                            <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>A-Z (Crescente ↑)
                            </option>
                            <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Z-A (Decrescente ↓)
                            </option>
                        </select>
                    </div>

                    {{-- Exibe botão para remover ordenação personalizada quando diferente do padrão --}}
                    @if ($sortOrder !== 'asc')
                        <div class="flex items-end">
                            <a href="{{ route('autores.index') }}" class="btn btn-sm btn-outline">
                                Limpar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </form>

        {{-- Mostra a tabela somente se houver autores cadastrados --}}
        @if ($autores->count() > 0)
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Livros escritos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Percorre a coleção de autores para montar as linhas da tabela --}}
                    @foreach ($autores as $autor)
                        <tr>
                            {{-- Foto do autor --}}
                            <td>
                                <img src="{{ asset($autor->foto) }}" class="w-16 h-16 rounded-full object-cover">
                            </td>

                            {{-- Nome com link para página de detalhes do autor --}}
                            <td>
                                <a href="{{ route('autores.show', $autor->id) }}" class="font-bold hover:underline">
                                    {{ $autor->nome }}
                                </a>
                            </td>

                            {{-- Lista os livros vinculados ao autor; caso contrário, mostra mensagem padrão --}}
                            <td>
                                @if ($autor->livros->count() > 0)
                                    <div class="flex flex-wrap items-center gap-x-1 max-w-xl">
                                        @foreach ($autor->livros as $livro)
                                            {{-- Adiciona separador entre os livros, exceto antes do primeiro item --}}
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

                            {{-- Ações disponíveis para cada autor --}}
                            <td>
                                <a href="{{ route('autores.edit', $autor->id) }}" class="btn btn-primary btn-sm">
                                    Editar
                                </a>

                                {{-- Formulário para exclusão do autor --}}
                                <form action="{{ route('autores.destroy', $autor->id) }}" method="POST"
                                    class="inline">
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
            {{-- Estado vazio quando não há resultados para os filtros atuais --}}
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">Nenhum autor encontrado.</p>
            </div>
        @endif
    </div>
</x-app-layout>
