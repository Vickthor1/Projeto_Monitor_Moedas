<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Monitor de Moedas')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="flex min-h-screen">
        <aside class="hidden xl:flex w-80 flex-col bg-slate-900 border-r border-slate-800">
            <div class="px-8 py-8 border-b border-slate-800">
                <div class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-400">Monitor Moedas</div>
                <div class="mt-3 text-3xl font-bold">Dashboard</div>
                <p class="mt-2 text-slate-400">Painel de cotações e histórico de conversões.</p>
            </div>

            <nav class="flex-1 px-6 py-8 space-y-2">
                <a href="{{ route('dashboard') }}" class="block rounded-3xl px-4 py-3 text-sm font-medium transition hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">Dashboard</a>
                <a href="{{ route('moeda.index') }}" class="block rounded-3xl px-4 py-3 text-sm font-medium transition hover:bg-slate-800 {{ request()->routeIs('moeda.*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">Consultar Moedas</a>
                <a href="{{ route('historico.index') }}" class="block rounded-3xl px-4 py-3 text-sm font-medium transition hover:bg-slate-800 {{ request()->routeIs('historico.*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">Histórico</a>
                <a href="{{ route('perfil.edit') }}" class="block rounded-3xl px-4 py-3 text-sm font-medium transition hover:bg-slate-800 {{ request()->routeIs('perfil.*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">Perfil</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full rounded-3xl bg-slate-800 px-4 py-3 text-left text-sm font-medium text-slate-200 transition hover:bg-slate-700">Sair</button>
                </form>
            </nav>

            <div class="px-6 py-6 border-t border-slate-800 text-sm text-slate-400">
                <p>Conectado como</p>
                <p class="mt-2 font-semibold text-white">{{ auth()->user()->nome }}</p>
            </div>
        </aside>

        <div class="flex-1">
            <header class="sticky top-0 z-20 border-b border-slate-800 bg-slate-950/95 backdrop-blur-xl px-4 py-4 xl:px-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Painel</p>
                        <h1 class="mt-2 text-3xl font-bold">Controle de Moedas</h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="rounded-3xl bg-slate-900 px-4 py-3 text-sm text-slate-200 shadow-lg shadow-slate-950/20">{{ date('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 rounded-3xl bg-emerald-500/10 border border-emerald-500/20 p-4 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
