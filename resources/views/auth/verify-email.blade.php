<x-guest-layout>
    {{-- Cartão central para confirmação do endereço de email do utilizador. --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Instrução para o utilizador verificar o email antes de prosseguir. --}}
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Antes de continuar, confirme o seu endereco de email clicando no link que acabamos de enviar. Se nao recebeu o email, enviamos outro de imediato.') }}
        </div>

        {{-- Mensagem de sucesso após reenvio do link de verificação. --}}
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Foi enviado um novo link de verificacao para o endereco de email definido no seu perfil.') }}
            </div>
        @endif

        {{-- Ações: reenviar email, editar perfil ou terminar sessão. --}}
        <div class="mt-4 flex items-center justify-between">
            {{-- Formulário para reenviar o email de verificação. --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button type="submit">
                        {{ __('Reenviar Email de Verificacao') }}
                    </x-button>
                </div>
            </form>

            {{-- Links para editar perfil ou terminar sessão. --}}
            <div>
                <a
                    href="{{ route('profile.show') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    {{ __('Editar Perfil') }}</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                        {{ __('Terminar Sessao') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>



