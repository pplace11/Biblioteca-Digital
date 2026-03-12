<x-app-layout>
    {{-- Container principal da tela de edição de editora --}}
    <div class="p-6 max-w-xl mx-auto">
        {{-- Título da página --}}
        <h1 class="text-2xl font-bold mb-6">
            Editar Editora
        </h1>

        {{-- Formulário para atualizar os dados da editora selecionada --}}
        <form method="POST" action="{{ route('editoras.update', $editora->id) }}" enctype="multipart/form-data">
            {{-- Token CSRF para proteção da requisição --}}
            @csrf
            {{-- Define a requisição como PUT para a rota de atualização --}}
            @method('PUT')

            {{-- Campo de nome da editora --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Nome</span>
                </label>
                <input type="text" name="nome" value="{{ $editora->nome }}" class="input input-bordered w-full">
            </div>

            {{-- Campo de upload para substituir o logótipo atual --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Logótipo</span>
                </label>
                <input type="file" name="logotipo" class="file-input file-input-bordered w-full" accept="image/*">
            </div>

            {{-- Exibe o logótipo atual somente se já existir imagem cadastrada --}}
            @if ($editora->logotipo)
                <div class="mb-4">
                    <img src="{{ asset($editora->logotipo) }}" class="w-24" alt="Logótipo atual">
                </div>
            @endif

            {{-- Botão para salvar as alterações --}}
            <button class="btn btn-primary">
                Atualizar
            </button>

            {{-- Link para cancelar e voltar para a listagem de editoras --}}
            <a href="{{ route('editoras.index') }}" class="btn btn-ghost">
                Cancelar
            </a>
        </form>
    </div>
</x-app-layout>
