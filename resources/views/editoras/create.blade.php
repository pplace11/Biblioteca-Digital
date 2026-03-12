<x-app-layout>
    {{-- Container principal da tela de cadastro de editora --}}
    <div class="p-6 max-w-xl mx-auto">
        {{-- Título da página --}}
        <h1 class="text-2xl font-bold mb-6">
            Criar Editora
        </h1>

        {{-- Formulário para criação de uma nova editora --}}
        <form method="POST" action="{{ route('editoras.store') }}" enctype="multipart/form-data">
            {{-- Token CSRF para segurança da requisição --}}
            @csrf

            {{-- Campo para nome da editora --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Nome da Editora</span>
                </label>
                <input type="text" name="nome" class="input input-bordered w-full" required>
            </div>

            {{-- Campo de upload do logotipo --}}
            <div class="mb-4">
                <label class="label">
                    <span class="label-text">Logotipo</span>
                </label>
                <input type="file" name="logotipo" id="logoInput" class="file-input file-input-bordered w-full"
                    accept="image/*" onchange="previewLogo(event)">
            </div>

            {{-- Área onde o logotipo selecionado será exibido antes do envio --}}
            <div class="mb-6">
                <p class="font-semibold mb-2">Preview do logotipo</p>
                <img id="logoPreview" class="w-24 h-24 rounded-full object-cover border shadow" style="display:none">
            </div>

            {{-- Botão para salvar o cadastro da editora --}}
            <button class="btn btn-success">
                Salvar Editora
            </button>

            {{-- Link para cancelar e voltar para a listagem --}}
            <a href="{{ route('editoras.index') }}" class="btn btn-ghost">
                Cancelar
            </a>
        </form>
    </div>

    {{-- Script responsável por mostrar preview do logotipo selecionado --}}
    <script>
        // Exibe a imagem escolhida no campo de upload antes do envio do formulário.
        function previewLogo(event) {
            const input = event.target;
            const preview = document.getElementById('logoPreview');

            // Garante que existe arquivo selecionado antes de gerar o preview.
            if (input.files && input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
                preview.style.display = "block";
            }
        }
    </script>
</x-app-layout>
