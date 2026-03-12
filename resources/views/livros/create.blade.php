<x-app-layout>
    {{-- Container principal da página de cadastro de livro --}}
    <div class="p-6 max-w-xl mx-auto">
        {{-- Título da tela --}}
        <h1 class="text-xl font-bold mb-4">
        Criar Livro
        </h1>

        {{-- Formulário para criação de um novo livro --}}
        <form method="POST" action="{{ route('livros.store') }}" enctype="multipart/form-data">
            {{-- Token CSRF para segurança da requisição --}}
            @csrf

            {{-- Campo de ISBN do livro --}}
            <input
            name="isbn"
            placeholder="ISBN"
            class="input input-bordered w-full mb-3">

            {{-- Campo de nome/título do livro --}}
            <input
            name="nome"
            placeholder="Nome do Livro"
            class="input input-bordered w-full mb-3">

            {{-- Seleção da editora vinculada ao livro --}}
            <select
            name="editora_id"
            class="select select-bordered w-full mb-3">
                {{-- Lista todas as editoras disponíveis --}}
                @foreach($editoras as $editora)
                    <option value="{{ $editora->id }}">
                        {{ $editora->nome }}
                    </option>
                @endforeach
            </select>

            {{-- Campo para informar o preço do livro --}}
            <input
            name="preco"
            placeholder="Preço"
            class="input input-bordered w-full mb-3">

            {{-- Seleção múltipla de autores relacionados ao livro --}}
            <label class="font-semibold">Autores</label>
            <select
            name="autores[]"
            multiple
            class="select select-bordered w-full mb-3">
                {{-- Lista todos os autores disponíveis para vínculo --}}
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}">
                        {{ $autor->nome }}
                    </option>
                @endforeach
            </select>

            {{-- Campo de texto para descrição/bibliografia do livro --}}
            <label class="font-semibold">Bibliografia</label>
            <textarea
            name="bibliografia"
            placeholder="Descrição ou bibliografia do livro..."
            class="textarea textarea-bordered w-full mb-3">
            </textarea>

            {{-- Upload da imagem de capa do livro --}}
            <label class="font-semibold">Capa do Livro</label>
            <input
            type="file"
            name="imagem_capa"
            class="file-input file-input-bordered w-full mb-4">

            {{-- Botão para salvar o cadastro do livro --}}
            <button class="btn btn-success">
                Salvar
            </button>
        </form>
    </div>
</x-app-layout>
