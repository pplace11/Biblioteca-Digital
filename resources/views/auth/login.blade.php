<x-guest-layout>
    {{-- Cartão central com o formulário de autenticação do utilizador. --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Botão para fechar o login e regressar à página inicial. --}}
        <div class="flex justify-end mb-2">
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100"
               aria-label="Fechar login"
               title="Fechar">
                &times;
            </a>
        </div>

        {{-- Lista de erros de validação (credenciais inválidas, campos em falta, etc.). --}}
        <x-validation-errors class="mb-4" />

        {{-- Mensagem de estado vinda da sessão (ex.: palavra-passe redefinida). --}}
        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        {{-- Formulário principal de entrada na aplicação. --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="Email" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Palavra-passe" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">Lembrar-me</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center gap-4">
                    {{-- Link de recuperação de palavra-passe, exibido apenas se a rota existir. --}}
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            Esqueceu a palavra-passe?
                        </a>
                    @endif

                    {{-- Link para registo de nova conta, condicionado pela rota. --}}
                    @if (Route::has('register'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                            Registar
                        </a>
                    @endif
                </div>

                <x-button>
                    Entrar
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>



