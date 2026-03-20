<x-guest-layout>
    {{-- Cartão central de autenticação para confirmação de identidade. --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Mensagem informativa antes da validação da palavra-passe. --}}
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Esta e uma area segura da aplicacao. Confirme a sua palavra-passe antes de continuar.') }}
        </div>

        {{-- Exibe erros de validação quando a confirmação falhar. --}}
        <x-validation-errors class="mb-4" />

        {{-- Formulário de confirmação exigido para aceder à área protegida. --}}
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('Palavra-passe') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Confirmar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>



