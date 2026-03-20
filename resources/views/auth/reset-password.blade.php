<x-guest-layout>
    {{-- Cartão principal do fluxo de redefinição de palavra-passe. --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Exibe mensagens de erro de validação do formulário. --}}
        <x-validation-errors class="mb-4" />

        {{-- Formulário que conclui a redefinição com token válido. --}}
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- Token recebido por link de email para autorizar a redefinição. --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Palavra-passe') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar Palavra-passe') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Redefinir Palavra-passe') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>



