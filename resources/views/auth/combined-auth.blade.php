<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação - Biblioteca Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Reset mínimo para consistência entre navegadores. */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            padding-bottom: 4.5rem;
            position: relative;
        }

        .page-footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            padding: 0.9rem 1rem;
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px solid #e5e7eb;
            color: #4b5563;
            font-size: 0.95rem;
        }

        .auth-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            min-height: 600px;
        }

        /* Painel informativo do lado esquerdo (branding e benefícios). */
        .auth-left {
            background: #111111;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .auth-left-content {
            position: relative;
            z-index: 1;
        }

        .auth-left h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .auth-left p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            line-height: 1.6;
        }

        .book-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            display: block;
        }

        .auth-left ul {
            list-style: none;
            text-align: left;
            display: inline-block;
        }

        .auth-left li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            opacity: 0.9;
        }

        .auth-left li:before {
            content: '✓';
            display: inline-block;
            margin-right: 0.75rem;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .auth-right {
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        /* Botão flutuante para regressar à página inicial. */
        .close-btn {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: #f0f0f0;
            border: none;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            color: #333;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .close-btn:hover {
            background: #e0e0e0;
            transform: rotate(90deg);
        }

        .auth-right h2 {
            font-size: 1.75rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .auth-right .subtitle {
            color: #999;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #555;
            font-weight: 500;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #111111;
            box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.1);
        }

        .password-input-wrap {
            position: relative;
        }

        .password-input-wrap input {
            padding-right: 5.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #666;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0.2rem 0.3rem;
        }

        .password-toggle:hover {
            color: #111111;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 0.75rem;
            cursor: pointer;
            accent-color: #111111;
        }

        .checkbox-group label {
            margin: 0;
            color: #666;
            cursor: pointer;
            font-weight: 400;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.85rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .btn-primary {
            background: #111111;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: #666;
            border: 2px solid #e0e0e0;
        }

        .btn-secondary:hover {
            border-color: #111111;
            color: #111111;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #999;
            font-size: 0.95rem;
        }

        .auth-footer a {
            color: #111111;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-footer a:hover {
            color: #444444;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border-left: 4px solid #c33;
        }

        .success-message {
            background: #efe;
            color: #3c3;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border-left: 4px solid #3c3;
        }

        .tab-toggle {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e0e0e0;
        }

        .tab-btn {
            padding: 0.75rem 1rem;
            border: none;
            background: transparent;
            color: #999;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .tab-btn.active {
            color: #111111;
            border-bottom-color: #111111;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Ajustes de layout para dispositivos móveis. */
        @media (max-width: 768px) {
            .auth-wrapper {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .auth-left {
                padding: 2rem;
                min-height: 300px;
            }

            .auth-left h1 {
                font-size: 1.75rem;
            }

            .auth-right {
                padding: 2rem;
            }

            .book-icon {
                font-size: 3rem;
            }

            .auth-left ul {
                display: none;
            }
        }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="close-btn" title="Fechar">&times;</a>

    <div class="auth-wrapper">
        {{-- Painel Esquerdo Visual --}}
        <div class="auth-left">
            <div class="auth-left-content">
                <span class="book-icon">📚</span>
                <h1>Bem-vindo à Biblioteca Digital</h1>
                <p>Gira as suas requisições de livros de forma simples e intuitiva</p>
                <ul>
                    <li>Acesso a milhares de livros</li>
                    <li>Requisição em tempo real</li>
                    <li>Controlo do histórico completo</li>
                    <li>Experiência segura, rápida e intuitiva</li>
                </ul>
            </div>
        </div>

        {{-- Painel Direito com Formulários e Abas --}}
        <div class="auth-right">
            {{-- Abas de navegação --}}
            <div class="tab-toggle">
                <button class="tab-btn active" onclick="switchTab('login', event)">Entrar</button>
                <button class="tab-btn" onclick="switchTab('register', event)">Registar-se</button>
            </div>

            {{-- TAB LOGIN --}}
            <div id="login" class="tab-content active">
                <h2>Bem-vindo de Volta</h2>
                <p class="subtitle">Entre com as suas credenciais</p>

                @if (session('status'))
                    <div class="success-message">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Formulário de entrada do utilizador existente. --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Palavra-passe</label>
                        <div class="password-input-wrap">
                            <input type="password" id="password" name="password" required autocomplete="current-password">
                            <button type="button" id="toggle-login-password" class="password-toggle" aria-label="Mostrar palavra-passe" aria-pressed="false">Mostrar</button>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label for="remember_me">Lembrar-me</label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="auth-footer">
                            <a href="{{ route('password.request') }}">Esqueceu a palavra-passe?</a>
                        </div>
                    @endif
                </form>
            </div>

            {{-- TAB REGISTER --}}
            <div id="register" class="tab-content">
                <h2>Registar-se</h2>
                <p class="subtitle">Junte-se à nossa comunidade</p>

                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Formulário de registo para criação de nova conta. --}}
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    </div>

                    <div class="form-group">
                        <label for="register_email">Email</label>
                        <input type="email" id="register_email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="register_password">Palavra-passe</label>
                        <div class="password-input-wrap">
                            <input type="password" id="register_password" name="password" required autocomplete="new-password">
                            <button type="button" id="toggle-register-password" class="password-toggle" aria-label="Mostrar palavra-passe" aria-pressed="false">Mostrar</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Palavra-passe</label>
                        <div class="password-input-wrap">
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                            <button type="button" id="toggle-register-password-confirmation" class="password-toggle" aria-label="Mostrar palavra-passe" aria-pressed="false">Mostrar</button>
                        </div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="checkbox-group">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">
                                Concordo com os
                                <a href="{{ route('terms.show') }}" target="_blank" style="color: #111111;">Termos</a> e
                                <a href="{{ route('policy.show') }}" target="_blank" style="color: #111111;">Política</a>
                            </label>
                        </div>
                    @endif

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Registar-se</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="page-footer">Biblioteca Digital © {{ date('Y') }}</footer>

    <script>
        // Ativa alternância visível/oculto nos campos de palavra-passe.
        function setupPasswordToggle(buttonId, inputId) {
            const button = document.getElementById(buttonId);
            const input = document.getElementById(inputId);

            if (!button || !input) {
                return;
            }

            button.addEventListener('click', function () {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.textContent = isPassword ? 'Ocultar' : 'Mostrar';
                button.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
                button.setAttribute('aria-label', isPassword ? 'Ocultar palavra-passe' : 'Mostrar palavra-passe');
            });
        }

        // Alterna entre abas de entrar e registo.
        function switchTab(tab, event) {
            if (event) {
                event.preventDefault();
            }

            // Esconder todos os tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

            // Mostrar tab selecionado
            document.getElementById(tab).classList.add('active');

            // Ativar o botão correto
            document.querySelectorAll('.tab-btn').forEach(btn => {
                if (btn.textContent.toLowerCase().includes(tab === 'login' ? 'entrar' : 'registar')) {
                    btn.classList.add('active');
                }
            });
        }

        // Define a aba inicial com base na rota atual e prepara os botões de palavra-passe.
        document.addEventListener('DOMContentLoaded', function() {
            const path = window.location.pathname;
            if (path.includes('register')) {
                switchTab('register', null);
            } else {
                switchTab('login', null);
            }

            setupPasswordToggle('toggle-login-password', 'password');
            setupPasswordToggle('toggle-register-password', 'register_password');
            setupPasswordToggle('toggle-register-password-confirmation', 'password_confirmation');
        });
    </script>
</body>
</html>



