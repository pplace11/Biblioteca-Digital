<x-app-layout>
    {{-- Container principal da página de cadastro de autor --}}
    <div class="p-6 max-w-xl mx-auto">
        {{-- Título da tela --}}
        <h1 class="text-2xl font-bold mb-6">
            Criar Novo Autor
        </h1>

        {{-- Formulário de envio para cadastro de um novo autor --}}
        <form method="POST" action="{{ route('autores.store') }}" enctype="multipart/form-data">
            {{-- Token CSRF obrigatório para segurança da requisição --}}
            @csrf

            {{-- Campo para informar o nome do autor --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Nome do Autor</span>
                </label>
                <input type="text" name="nome" class="input input-bordered w-full" required>
            </div>

            {{-- Campo de texto para descrever a biografia do autor --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Biografia</span>
                </label>
                <textarea name="bibliografia" class="textarea textarea-bordered w-full" rows="4"
                    placeholder="Escreva a biografia do autor..."></textarea>
            </div>

            {{-- Campo para upload da foto do autor --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Foto do Autor</span>
                </label>
                <input type="file" name="foto" class="file-input file-input-bordered w-full">
            </div>

            {{-- Botão para enviar o formulário e salvar o autor --}}
            <button class="btn btn-primary">
                Salvar Autor
            </button>

            {{-- Link para voltar à listagem sem salvar alterações --}}
            <a href="{{ route('autores.index') }}" class="btn btn-ghost">
                Cancelar
            </a>
        </form>
    </div>
</x-app-layout>
