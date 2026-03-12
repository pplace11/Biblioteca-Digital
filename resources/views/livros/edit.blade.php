<x-app-layout>
    {{-- Container principal da tela de edição de livro --}}
    <div class="p-6 max-w-3xl mx-auto">
        {{-- Título da página --}}
        <h1 class="text-2xl font-bold mb-6">
            Editar Livro
        </h1>

        {{-- Formulário de atualização do livro selecionado --}}
        <form method="POST" action="{{ route('livros.update',$livro->id) }}" enctype="multipart/form-data">
            {{-- Token CSRF para segurança da requisição --}}
            @csrf
            {{-- Sobrescreve o método HTTP para PUT na rota de update --}}
            @method('PUT')

            {{-- Campo ISBN do livro --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">ISBN</span>
                </label>
                <input
                type="text"
                name="isbn"
                value="{{ $livro->isbn }}"
                class="input input-bordered w-full">
            </div>

            {{-- Campo de nome/título do livro --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Nome</span>
                </label>
                <input
                type="text"
                name="nome"
                value="{{ $livro->nome }}"
                class="input input-bordered w-full">
            </div>

            {{-- Seleção da editora vinculada ao livro --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Editora</span>
                </label>
                <select
                name="editora_id"
                class="select select-bordered w-full">
                    {{-- Lista todas as editoras e marca a editora atual do livro --}}
                    @foreach($editoras as $editora)
                        <option
                        value="{{ $editora->id }}"
                        {{ $livro->editora_id == $editora->id ? 'selected' : '' }}>
                            {{ $editora->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Campo de preço do livro --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Preço</span>
                </label>
                <input
                type="number"
                step="0.01"
                name="preco"
                value="{{ $livro->preco }}"
                class="input input-bordered w-full">
            </div>

            {{-- Seleção múltipla de autores vinculados ao livro --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Autores</span>
                </label>
                <select
                name="autores[]"
                multiple
                class="select select-bordered w-full h-40">
                    {{-- Marca como selecionados os autores já associados ao livro --}}
                    @foreach($autores as $autor)
                        <option
                        value="{{ $autor->id }}"
                        {{ $livro->autores->contains($autor->id) ? 'selected' : '' }}>
                            {{ $autor->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Campo de bibliografia/descrição do livro --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Bibliografia</span>
                </label>
                <textarea
                name="bibliografia"
                class="textarea textarea-bordered w-full">
                    {{ $livro->bibliografia }}
                </textarea>
            </div>

            {{-- Upload para substituir a capa do livro --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Capa do Livro</span>
                </label>
                <input
                type="file"
                name="imagem_capa"
                class="file-input file-input-bordered w-full">

                {{-- Exibe a capa atual quando já existir imagem cadastrada --}}
                @if($livro->imagem_capa)
                    <div class="mt-3">
                        <img src="{{ asset($livro->imagem_capa) }}" alt="Capa atual" class="w-20 h-28 object-cover rounded">
                    </div>
                @endif
            </div>

            {{-- Ações finais do formulário: salvar ou cancelar --}}
            <div class="flex gap-3">
                <button class="btn btn-primary">
                    Atualizar
                </button>
                <a href="{{ route('livros.index') }}" class="btn btn-ghost">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
