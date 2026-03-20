<x-guest-layout>
    {{-- Cartão principal para o fluxo de recuperação de palavra-passe. --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Instrução para o utilizador sobre o envio do link de redefinição. --}}
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Esqueceu a sua palavra-passe? Sem problema. Indique o seu endereco de email e enviaremos um link para redefinir a palavra-passe.') }}
        </div>

        {{-- Mensagem de sucesso exibida após solicitação do email. --}}
        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        {{-- Erros de validação do formulário (email inválido, campo vazio, etc.). --}}
        <x-validation-errors class="mb-4" />

        {{-- Formulário que dispara o envio do link para redefinir a palavra-passe. --}}
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Enviar Link de Redefinicao') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>



