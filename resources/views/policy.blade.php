<x-guest-layout>
    {{-- Fundo e espaçamento externo da página de política --}}
    <div class="pt-4 bg-gray-100">
        {{-- Container central que organiza logo e conteúdo em coluna --}}
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            {{-- Logotipo da autenticação exibido no topo --}}
            <div>
                <x-authentication-card-logo />
            </div>

            {{-- Card com o conteúdo da política (HTML já renderizado) --}}
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-guest-layout>
