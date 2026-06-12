<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Monitor de Moedas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen text-slate-100" data-theme="dark">
    <div class="app-grid">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-mark">MM</div>
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-cyan-300/80">Monitor</p>
                    <p class="text-2xl font-semibold text-white">Moedas</p>
                </div>
            </div>

            <nav class="grid gap-2">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-label="Navegar para dashboard">
                    @include('components.nav-icon', ['name' => 'grid'])
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('moeda.index') }}" class="nav-item {{ request()->routeIs('moeda.*') ? 'active' : '' }}" aria-label="Navegar para consultar moedas">
                    @include('components.nav-icon', ['name' => 'arrows'])
                    <span>Conversão</span>
                </a>
                <a href="{{ route('historico.index') }}" class="nav-item {{ request()->routeIs('historico.*') ? 'active' : '' }}" aria-label="Navegar para histórico de consultas">
                    @include('components.nav-icon', ['name' => 'clock'])
                    <span>Histórico</span>
                </a>
                <a href="{{ route('perfil.edit') }}" class="nav-item {{ request()->routeIs('perfil.*') ? 'active' : '' }}" aria-label="Navegar para perfil do usuário">
                    @include('components.nav-icon', ['name' => 'user'])
                    <span>Perfil</span>
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="btn-ghost w-full text-left">@include('components.nav-icon', ['name' => 'logout']) Sair</button>
            </form>

            <div class="sidebar-footer">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Conectado como</p>
                <p class="mt-2 font-semibold text-white">{{ optional(auth()->user())->nome ?? 'Usuário' }}</p>
            </div>
        </aside>

        <div class="app-main">
            <header class="topbar">
                <div class="flex items-center gap-4">
                    <button id="mobileMenuToggle" type="button" class="btn-ghost hidden-desktop">Menu</button>
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-400">Dashboard</p>
                        <h1 class="text-2xl font-semibold text-white">Painel Monitor de Moedas</h1>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button id="themeToggle" type="button" class="btn-ghost rounded-full px-4 py-3" aria-label="Alternar tema">
                        <span id="themeIcon">🌙</span>
                    </button>
                    <div class="rounded-3xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-200">{{ date('d/m/Y H:i') }}</div>
                </div>
            </header>

            <div id="mobileDrawer" class="mobile-drawer" aria-hidden="true">
                <div class="mobile-panel glass-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-cyan-300/80">Menu</p>
                            <h2 class="text-xl font-semibold text-white">Navegação</h2>
                        </div>
                        <button id="mobileMenuClose" type="button" class="btn-ghost" aria-label="Fechar menu móvel">Fechar</button>
                    </div>
                    <nav class="mt-8 grid gap-3">
                        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">@include('components.nav-icon', ['name' => 'grid']) Dashboard</a>
                        <a href="{{ route('moeda.index') }}" class="nav-item {{ request()->routeIs('moeda.*') ? 'active' : '' }}">@include('components.nav-icon', ['name' => 'arrows']) Conversão</a>
                        <a href="{{ route('historico.index') }}" class="nav-item {{ request()->routeIs('historico.*') ? 'active' : '' }}">@include('components.nav-icon', ['name' => 'clock']) Histórico</a>
                        <a href="{{ route('perfil.edit') }}" class="nav-item {{ request()->routeIs('perfil.*') ? 'active' : '' }}">@include('components.nav-icon', ['name' => 'user']) Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-ghost w-full text-left">@include('components.nav-icon', ['name' => 'logout']) Sair</button>
                        </form>
                    </nav>
                </div>
            </div>

            <main class="main-content">
                <div class="toast-container" aria-live="polite" aria-atomic="true"></div>
                @if(session('success'))
                    <div class="card mb-6 border-cyan-500/20 bg-cyan-500/10 p-4 text-slate-50">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
