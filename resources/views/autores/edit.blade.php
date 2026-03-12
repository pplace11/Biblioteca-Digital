<x-app-layout>
    {{-- Container principal da tela de edição de autor --}}
    <div class="p-6 max-w-xl mx-auto">
        {{-- Título da página --}}
        <h1 class="text-2xl font-bold mb-6">
            Editar Autor
        </h1>

        {{-- Formulário para atualizar os dados do autor selecionado --}}
        <form method="POST" action="{{ route('autores.update', $autor->id) }}" enctype="multipart/form-data">
            {{-- Token CSRF para proteger a requisição --}}
            @csrf
            {{-- Sobrescreve o método HTTP para PUT na rota de atualização --}}
            @method('PUT')

            {{-- Campo de nome, preenchido com valor antigo em caso de erro ou valor atual do autor --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Nome</span>
                </label>
                <input type="text" name="nome" class="input input-bordered w-full" value="{{ old('nome', $autor->nome) }}" required>
            </div>

            {{-- Campo de biografia, mantendo o valor enviado anteriormente se a validação falhar --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Biografia</span>
                </label>
                <textarea name="bibliografia" class="textarea textarea-bordered w-full" rows="4">{{ old('bibliografia', $autor->bibliografia) }}</textarea>
            </div>

            {{-- Campo para enviar uma nova foto do autor --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Foto do Autor</span>
                </label>
                <input type="file" name="foto" class="file-input file-input-bordered w-full">

                {{-- Mostra a foto atual do autor caso já exista uma imagem cadastrada --}}
                @if($autor->foto)
                    <div class="mt-3">
                        <img src="{{ asset($autor->foto) }}" alt="Foto atual" class="w-20 h-20 rounded-full object-cover">
                    </div>
                @endif
            </div>

            {{-- Botão para salvar as alterações --}}
            <button class="btn btn-primary">
                Atualizar
            </button>

            {{-- Link para cancelar e voltar à listagem de autores --}}
            <a href="{{ route('autores.index') }}" class="btn btn-ghost">
                Cancelar
            </a>
        </form>
    </div>
</x-app-layout>
