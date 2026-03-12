<!DOCTYPE html>
<html lang="pt">

<head>
    {{-- Metadados básicos da página inicial --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Define o nome da aplicação com fallback para Biblioteca --}}
    @php
        $configuredName = config('app.name');
        $appName = empty($configuredName) || $configuredName === 'Laravel' ? 'Biblioteca' : $configuredName;
    @endphp

    {{-- Título exibido na aba do navegador --}}
    <title>Inicio - {{ $appName }}</title>

    {{-- Ícone (favicon) da aplicação --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo/inovcorp.png') }}">

    {{-- Estilos utilitários via CDN (DaisyUI + Tailwind Browser) --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-base-200">
    {{-- Barra de navegação principal com acesso a login e registo --}}
    <div class="navbar bg-base-100 shadow">
        <div class="flex-1">
            <a href="{{ url('/') }}">
                <x-application-logo class="block h-12 w-auto" />
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-primary">
                Entrar
            </a>
            <a href="{{ route('register') }}" class="btn btn-secondary">
                Registrar
            </a>
        </div>
    </div>

    {{-- Seção hero de apresentação do sistema --}}
    <div class="hero min-h-[60vh]">
        <div class="hero-content text-center">
            <div>
                <h1 class="text-5xl font-bold">
                    Sistema de Biblioteca
                </h1>
                <p class="py-6 text-lg">
                    Gestão moderna de livros, autores e editoras.
                </p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    Entrar
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">
                Registrar
                </a>
            </div>
        </div>
    </div>

    {{-- Bloco de estatísticas gerais da biblioteca --}}
    <div class="p-10">
        <h2 class="text-3xl font-bold text-center mb-8">
            Estatísticas da Biblioteca
        </h2>
        <div class="grid grid-cols-3 gap-6">
            {{-- Card de total de livros --}}
            <div class="stat bg-base-100 shadow">
                <div class="stat-title">Livros</div>
                <div class="stat-value">{{ $totalLivros }}</div>
            </div>

            {{-- Card de total de autores --}}
            <div class="stat bg-base-100 shadow">
                <div class="stat-title">Autores</div>
                <div class="stat-value">{{ $totalAutores }}</div>
            </div>

            {{-- Card de total de editoras --}}
            <div class="stat bg-base-100 shadow">
                <div class="stat-title">Editoras</div>
                <div class="stat-value">{{ $totalEditoras }}</div>
            </div>
        </div>
    </div>

    {{-- Grade com livros em destaque --}}
    <div class="p-10">
        <h2 class="text-3xl font-bold text-center mb-8">
            Livros em Destaque
        </h2>
        <div class="grid grid-cols-3 gap-6">
            {{-- Percorre os livros enviados para exibir os cards --}}
            @foreach ($livros as $livro)
                <div class="card bg-base-100 shadow">
                    <figure>
                        {{-- Exibe capa do livro quando existir imagem cadastrada --}}
                        @if ($livro->imagem_capa)
                            <img src="{{ asset($livro->imagem_capa) }}" class="h-64 object-cover">
                        @endif
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">
                            {{ $livro->nome }}
                        </h2>

                        {{-- Lista os autores do livro com separador visual --}}
                        <p class="text-sm text-gray-800">
                            @foreach ($livro->autores as $autor)
                                @if (!$loop->first)<span class="text-gray-400">|</span>@endif
                                {{ $autor->nome }}
                            @endforeach
                        </p>

                        {{-- Preço do livro --}}
                        <p class="font-bold">
                            € {{ $livro->preco }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Rodapé institucional da página inicial --}}
    <footer class="footer footer-center p-6 bg-base-100">
        <p>
            Sistema Biblioteca © {{ date('Y') }}
        </p>
    </footer>
</body>
</html>
