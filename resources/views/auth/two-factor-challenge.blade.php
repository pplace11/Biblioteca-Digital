<x-guest-layout>
    {{-- Cartão de autenticação para o segundo fator (2FA). --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Estado Alpine: alterna entre código da app autenticadora e código de recuperação. --}}
        <div x-data="{ recovery: false }">
            {{-- Mensagem padrão quando o utilizador usa o código temporário da app. --}}
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Confirme o acesso a sua conta introduzindo o codigo de autenticacao fornecido pela sua aplicacao autenticadora.') }}
            </div>

            {{-- Mensagem exibida ao mudar para modo de recuperação de emergência. --}}
            <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                {{ __('Confirme o acesso a sua conta introduzindo um dos seus codigos de recuperacao de emergencia.') }}
            </div>

            {{-- Erros de validação do código submetido. --}}
            <x-validation-errors class="mb-4" />

            {{-- Formulário de envio do segundo fator para validação no backend. --}}
            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                {{-- Campo para código temporário gerado pela aplicação autenticadora. --}}
                <div class="mt-4" x-show="! recovery">
                    <x-label for="code" value="{{ __('Codigo') }}" />
                    <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                {{-- Campo alternativo para código de recuperação guardado pelo utilizador. --}}
                <div class="mt-4" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Codigo de Recuperacao') }}" />
                    <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    {{-- Alterna para modo de recuperação e foca o campo correspondente. --}}
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Usar um codigo de recuperacao') }}
                    </button>

                    {{-- Volta ao modo de código autenticador e repõe o foco no campo principal. --}}
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-cloak
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Usar um codigo de autenticacao') }}
                    </button>

                    <x-button class="ms-4">
                        {{ __('Entrar') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>



