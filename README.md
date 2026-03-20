
# 📚 Biblioteca Digital

Biblioteca Digital é uma aplicação web desenvolvida em Laravel para gestão de livros, autores e editoras.
O sistema permite organizar uma biblioteca digital, visualizar obras, autores e editoras, além de exportar dados para Excel.

A aplicação possui autenticação segura e interface moderna utilizando Tailwind CSS e DaisyUI.

---



## 📋 Funcionalidades

### 📚 Livros
- Registo, consulta, edição e remoção de livros (ISBN, nome, editora, autores, bibliografia, preço, capa)
- Exportação da lista de livros para Excel

### 👤 Autores
- Registo, consulta, edição e remoção de autores (nome, fotografia, biografia)
- Visualização dos livros escritos por cada autor

### 🏢 Editoras
- Registo, consulta, edição e remoção de editoras (nome, logótipo)
- Visualização dos livros publicados por cada editora

### 📄 Requisições (Empréstimos)
- Utilizadores podem requisitar livros e acompanhar o estado
- Administração de requisições: filtro, encerramento e confirmação de devoluções
- Histórico completo de empréstimos

### 🔔 Notificações
- Alertas automáticos sobre devoluções, confirmações e lembretes
- Marcação de notificações como lidas (individualmente ou todas)

### 📊 Visualização de Dados
- Painel dinâmico com estatísticas para administrador e cidadão (filtros por estado, data e pesquisa)
- Página de autor/editora com biografia, livros e autores relacionados
- Pesquisa avançada por livros, autores, editoras e requisições

---



## 🛠️ Tecnologias Utilizadas

- **Laravel 12** — Backend PHP robusto
- **Laravel Jetstream** — Autenticação (login, registo, 2FA)
- **Laravel Sanctum** — Autenticação de API
- **Laravel Livewire 3** — Componentes dinâmicos em tempo real
- **Maatwebsite Excel** — Exportação de dados para Excel
- **Tailwind CSS 3.4** — Estilização moderna e responsiva
- **DaisyUI 5** — Componentes UI prontos para Tailwind
- **Vite 7** — Build e hot reload frontend
- **MySQL** — Base de dados relacional

---


## ⚙️ Como Executar o Projeto

### Pré-requisitos
Certifique-se de ter instalado:

### 1. Clonar o repositório
```bash
git clone <url-do-repositório>
cd biblioteca
```

### 2. Instalação e configuração automática (recomendado)
Utilize o script de setup para instalar dependências, criar o .env, gerar a chave, migrar e compilar os assets:
```bash
composer run setup
```

### 3. Configuração manual (opcional)
Se preferir, siga os passos manualmente:
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

### 4. Executar o ambiente de desenvolvimento
Para correr o servidor Laravel, fila e Vite em simultâneo:
```bash
composer run dev
```

### 5. Aceder à aplicação
Abra http://localhost:8000

---

## 📁 Estrutura do Projeto


```
📁 biblioteca/
├── 📁 app/
│   ├── 📁 Actions/
│   │   ├── 📁 Fortify/
│   │   │   ├── 📄 CreateNewUser.php                # Criação de novo usuário
│   │   │   ├── 📄 PasswordValidationRules.php       # Regras de senha
│   │   │   ├── 📄 ResetUserPassword.php             # Reset de senha
│   │   │   ├── 📄 UpdateUserPassword.php            # Atualização de senha
│   │   │   └── 📄 UpdateUserProfileInformation.php  # Atualização de perfil
│   │   └── 📁 Jetstream/
│   │       └── 📄 DeleteUser.php                    # Exclusão de usuário
│   ├── 📁 Exports/
│   │   └── 📄 LivrosExport.php            # Exportação de livros para Excel
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── 📄 AdminUserController.php      # Gestão de administradores
│   │   │   ├── 📄 AutorController.php          # CRUD de autores
│   │   │   ├── 📄 Controller.php               # Base para outros controllers
│   │   │   ├── 📄 DashboardController.php      # Lógica do painel principal
│   │   │   ├── 📄 EditoraController.php        # CRUD de editoras
│   │   │   ├── 📄 LivroController.php          # CRUD de livros
│   │   │   ├── 📄 NotificationController.php   # Notificações do sistema
│   │   │   └── 📄 RequisicaoController.php     # Gestão de requisições (empréstimos)
│   │   └── 📁 Middleware/
│   │       └── 📄 AdminMiddleware.php               # Middleware de admin
│   ├── 📁 Models/
│   │   ├── 📄 Autor.php                   # Modelo de autor
│   │   ├── 📄 Editora.php                 # Modelo de editora
│   │   ├── 📄 Livro.php                   # Modelo de livro
│   │   ├── 📄 Requisicao.php              # Modelo de requisição (empréstimo)
│   │   └── 📄 User.php                    # Modelo de utilizador
│   ├── 📁 Notifications/
│   │   ├── 📄 DevolucaoSolicitadaNotification.php     # Notificação de devolução solicitada
│   │   ├── 📄 LembreteEntregaRequisicaoNotification.php # Notificação de lembrete de entrega
│   │   ├── 📄 RecepcaoConfirmadaNotification.php      # Notificação de recepção confirmada
│   │   └── 📄 RequisicaoCriadaNotification.php        # Notificação de requisição criada
│   ├── 📁 Providers/
│   │   ├── 📄 AppServiceProvider.php         # Configurações globais da aplicação
│   │   ├── 📄 FortifyServiceProvider.php     # Configuração do Fortify (autenticação)
│   │   └── 📄 JetstreamServiceProvider.php   # Configuração do Jetstream
│   └── 📁 View/
│       └── 📁 Components/
│           ├── 📄 action-message.blade.php          # Mensagem de ação
│           ├── 📄 action-section.blade.php          # Seção de ação
│           ├── 📄 application-logo.blade.php        # Logo da aplicação
│           ├── 📄 application-mark.blade.php        # Marca da aplicação
│           ├── 📄 authentication-card-logo.blade.php# Logo do cartão de autenticação
│           ├── 📄 authentication-card.blade.php     # Cartão de autenticação
│           ├── 📄 banner.blade.php                  # Banner
│           ├── 📄 button.blade.php                  # Botão
│           ├── 📄 checkbox.blade.php                # Checkbox
│           ├── 📄 confirmation-modal.blade.php      # Modal de confirmação
│           ├── 📄 confirms-password.blade.php       # Confirmação de senha
│           ├── 📄 danger-button.blade.php           # Botão de perigo
│           ├── 📄 dialog-modal.blade.php            # Modal de diálogo
│           ├── 📄 dropdown-link.blade.php           # Link de dropdown
│           ├── 📄 dropdown.blade.php                # Dropdown
│           ├── 📄 form-section.blade.php            # Seção de formulário
│           ├── 📄 input-error.blade.php             # Erro de input
│           ├── 📄 input.blade.php                   # Input
│           ├── 📄 label.blade.php                   # Label
│           ├── 📄 modal.blade.php                   # Modal
│           ├── 📄 nav-link.blade.php                # Link de navegação
│           ├── 📄 responsive-nav-link.blade.php     # Link de navegação responsivo
│           ├── 📄 secondary-button.blade.php        # Botão secundário
│           ├── 📄 section-border.blade.php          # Borda de seção
│           ├── 📄 section-title.blade.php           # Título de seção
│           ├── 📄 switchable-team.blade.php         # Troca de equipe
│           ├── 📄 validation-errors.blade.php       # Erros de validação
│           └── 📄 welcome.blade.php                 # Boas-vindas
├── 📁 bootstrap/
├── 📁 config/
├── 📁 database/
│   ├── 📁 factories/
│   │   └── 📄 UserFactory.php                # Fábrica de usuários para testes
│   ├── 📁 migrations/
│   └── 📁 seeders/
│       ├── 📄 AutorSeeder.php                # Popula autores de exemplo
│       ├── 📄 DatabaseSeeder.php             # Seeder principal
│       ├── 📄 EditoraSeeder.php              # Popula editoras de exemplo
│       └── 📄 LivroSeeder.php                # Popula livros de exemplo
├── 📁 docs/
├── 📁 node_modules/
├── 📁 public/
│   ├── 📁 build/
│   ├── 📁 images/
│   │   ├── 📁 autores/
│   │   ├── 📁 capas/
│   │   ├── 📁 editoras/
│   │   └── 📁 logo/
│   ├── 📄 favicon.ico                        # Ícone do site
│   ├── 📄 index.php                          # Front controller do Laravel
│   ├── 📄 inovcorp.png                       # Logomarca
│   ├── 📄 robots.txt                         # Permissões para robôs de busca
│   └── 📁 storage
├── 📁 resources/
│   ├── 📁 css/
│   ├── 📁 js/
│   ├── 📁 markdown/
│   └── 📁 views/
│       ├── 📁 admin/
│       │   ├── 📄 dashboard.blade.php               # Dashboard admin
│       │   └── 📁 users/
│       │       ├── 📄 create.blade.php              # Criar admin
│       │       └── 📄 index.blade.php               # Listar admins
│       ├── 📁 api/
│       │   ├── 📄 api-token-manager.blade.php       # Gerenciar tokens API
│       │   └── 📄 index.blade.php                   # Index API
│       ├── 📁 auth/
│       │   ├── 📄 combined-auth.blade.php           # Login/registro unificado
│       │   ├── 📄 confirm-password.blade.php        # Confirmação de senha
│       │   ├── 📄 forgot-password.blade.php         # Esqueci a senha
│       │   ├── 📄 login.blade.php                   # Login
│       │   ├── 📄 register.blade.php                # Registro
│       │   ├── 📄 reset-password.blade.php          # Resetar senha
│       │   ├── 📄 two-factor-challenge.blade.php    # 2FA
│       │   └── 📄 verify-email.blade.php            # Verificação de email
│       ├── 📁 autores/
│       ├── 📁 cidadao/
│       ├── 📁 components/ # (ver acima)
│       ├── 📁 editoras/
│       ├── 📁 emails/
│       │   └── 📄 team-invitation.blade.php         # Convite de equipe
│       ├── 📁 layouts/
│       │   ├── 📄 app.blade.php                     # Layout autenticado
│       │   └── 📄 guest.blade.php                   # Layout visitante
│       ├── 📁 livros/
│       ├── 📁 profile/
│       │   ├── 📄 delete-user-form.blade.php        # Excluir usuário
│       │   ├── 📄 logout-other-browser-sessions-form.blade.php # Logout outros browsers
│       │   ├── 📄 show.blade.php                    # Perfil
│       │   ├── 📄 two-factor-authentication-form.blade.php # 2FA
│       │   ├── 📄 update-password-form.blade.php    # Atualizar senha
│       │   └── 📄 update-profile-information-form.blade.php # Atualizar perfil
│       ├── 📁 requisicoes/
│       ├── 📁 vendor/
│       │   └── 📁 mail/
│       │       ├── 📁 html/
│       │       │   └── 📄 header.blade.php          # Header HTML email
│       │       └── 📁 text/
│       │           └── 📄 header.blade.php          # Header texto email
│       ├── 📄 navigation-menu.blade.php      # Menu de navegação
│       ├── 📄 policy.blade.php               # Política de privacidade
│       ├── 📄 terms.blade.php                # Termos de serviço
│       ├── 📄 welcome.blade.php              # Página inicial pública
├── 📁 routes/
│   ├── 📄 api.php                            # Rotas da API
│   ├── 📄 console.php                        # Comandos Artisan personalizados
│   └── 📄 web.php                            # Rotas web da aplicação
├── 📁 storage/
├── 📁 tests/
│   ├── 📁 Feature/
│   │   ├── 📄 ApiTokenPermissionsTest.php            # Teste permissões API
│   │   ├── 📄 AuthenticationTest.php                 # Teste autenticação
│   │   ├── 📄 BrowserSessionsTest.php                # Teste sessões browser
│   │   ├── 📄 CreateApiTokenTest.php                 # Teste criação token
│   │   ├── 📄 DeleteAccountTest.php                  # Teste exclusão conta
│   │   ├── 📄 DeleteApiTokenTest.php                 # Teste exclusão token
│   │   ├── 📄 EmailVerificationTest.php              # Teste verificação email
│   │   ├── 📄 ExampleTest.php                        # Exemplo
│   │   ├── 📄 LembreteEntregaRequisicaoTest.php      # Teste lembrete entrega
│   │   ├── 📄 LivroRequisicaoTest.php                # Teste requisição livro
│   │   ├── 📄 PasswordConfirmationTest.php           # Teste confirmação senha
│   │   ├── 📄 PasswordResetTest.php                  # Teste reset senha
│   │   ├── 📄 ProfileInformationTest.php             # Teste perfil
│   │   ├── 📄 RegistrationTest.php                   # Teste registro
│   │   ├── 📄 TwoFactorAuthenticationSettingsTest.php# Teste 2FA
│   │   ├── 📄 UpdatePasswordTest.php                 # Teste atualização senha
│   ├── 📄 Pest.php                                  # Configuração do Pest (testes)
│   ├── 📄 TestCase.php                              # Base para testes
│   └── 📁 Unit/
│       └── 📄 ExampleTest.php                       # Exemplo unitário
├── 📄 artisan                                # CLI do Laravel
├── 📄 composer.json                          # Dependências PHP
├── 📄 composer.lock                          # Lockfile do Composer
├── 📄 package.json                           # Dependências JS
├── 📄 package-lock.json                      # Lockfile do npm
├── 📄 phpunit.xml                            # Configuração de testes PHPUnit
├── 📄 postcss.config.js                      # Configuração do PostCSS
├── 📄 tailwind.config.js                     # Configuração do Tailwind
├── 📄 vite.config.js                         # Configuração do Vite
└── 📄 README.md                              # Documentação do projeto
```
