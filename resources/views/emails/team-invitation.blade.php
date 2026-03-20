@component('mail::message')
{{-- Saudação e informação sobre o convite para a equipa --}}
{{ __('Foi convidado para integrar a equipa :team!', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
	{{-- Instruções para criar conta, caso o destinatário ainda não tenha --}}
	{{ __('Se ainda nao tiver conta, pode criar uma clicando no botao abaixo. Depois de criar a conta, clique no botao de aceitacao neste email para aceitar o convite da equipa:') }}

	{{-- Botão para criar conta --}}
	@component('mail::button', ['url' => route('register')])
		{{ __('Criar Conta') }}
	@endcomponent

	{{-- Instrução para quem já tem conta --}}
	{{ __('Se ja tiver conta, pode aceitar este convite clicando no botao abaixo:') }}
@else
	{{-- Instrução para aceitar convite caso não haja registro habilitado --}}
	{{ __('Pode aceitar este convite clicando no botao abaixo:') }}
@endif

{{-- Botão para aceitar o convite da equipa --}}
@component('mail::button', ['url' => $acceptUrl])
	{{ __('Aceitar Convite') }}
@endcomponent

{{-- Mensagem final caso o destinatário não reconheça o convite --}}
{{ __('Se nao estava a espera de receber um convite para esta equipa, pode ignorar este email.') }}
@endcomponent



