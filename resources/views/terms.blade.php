<x-guest-layout>
    {{-- Fundo e espaçamento externo da página de termos --}}
    <div class="pt-4 bg-gray-100">
        {{-- Container central com organização vertical do conteúdo --}}
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            {{-- Logotipo exibido no topo da página --}}
            <div>
                <x-authentication-card-logo />
            </div>

            {{-- Card com os termos de serviço (HTML já renderizado) --}}
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
