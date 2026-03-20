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
    {{-- Navbar da home no mesmo estilo da navegação do cidadão --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 grid grid-cols-[auto_1fr_auto] items-center gap-6">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="shrink-0">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <div class="hidden sm:flex items-center justify-center gap-2">
                        <a href="{{ route('livros.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition">
                            Livros
                        </a>
                        @auth
                            <a href="{{ route('requisicoes.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition">
                                Requisição
                            </a>
                        @endauth
                        <a href="{{ route('autores.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition">
                            Autores
                        </a>
                        <a href="{{ route('editoras.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition">
                            Editoras
                        </a>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-xl text-sm font-semibold bg-black text-white border border-black hover:bg-neutral-800 transition">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="px-3 py-2 rounded-xl text-sm font-semibold bg-white text-black border border-black hover:bg-gray-100 transition">
                        Registar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Seção hero de apresentação da biblioteca digital --}}
    <div id="inicio" class="hero min-h-[60vh]">
        <div class="hero-content text-center">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Biblioteca Digital</p>
                <h1 class="text-5xl font-bold mt-3">
                    O seu acervo literário, disponível em qualquer momento
                </h1>
                <p class="py-6 text-lg">
                    Descubra livros, conheça autores, acompanhe editoras e faça requisições online com uma experiência simples, rápida
                    e moderna.
                </p>
                <a href="{{ route('login') }}" class="btn btn-lg bg-black text-white border-black hover:bg-gray-900 hover:text-white">
                    Entrar
                </a>
                <a href="{{ route('register') }}" class="btn btn-lg btn-outline">
                    Registar
                </a>
            </div>
        </div>
    </div>

    {{-- Grade com livros em destaque --}}
    <div id="destaques" class="p-10">
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

                        {{-- Preço do livro formatado em euros --}}
                        <p class="text-base font-semibold text-gray-900">
                            @if (!is_null($livro->preco))
                                {{ number_format((float) $livro->preco, 2, ',', '.') }} &euro;
                            @else
                                -
                            @endif
                        </p>

                        {{-- Botão para requisitar direcionando ao login --}}
                        <a href="{{ route('login') }}" class="btn btn-sm mt-1 bg-black text-white border-black hover:bg-gray-900 hover:text-white">
                            Requisitar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Rodapé institucional da página inicial --}}
    <footer class="footer footer-center p-6 bg-base-100">
        <p>
            Biblioteca Digital © {{ date('Y') }}
        </p>
    </footer>
</body>
</html>



