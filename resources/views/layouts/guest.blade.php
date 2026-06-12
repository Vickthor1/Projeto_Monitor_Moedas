<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100" data-theme="dark">
    <div class="min-h-screen px-4 py-8">
        <div class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-7xl flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-8 lg:max-w-xl">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-white/10 shadow-glow shadow-cyan-500/20">
                    <span class="text-2xl font-black text-cyan-300">M</span>
                </div>
                <div class="space-y-4">
                    <p class="text-sm uppercase tracking-[0.35em] text-cyan-300/80">Monitor Moedas</p>
                    <h1 class="max-w-2xl text-4xl font-black tracking-tight text-white sm:text-5xl">Painel de conversão com design premium e dados confiáveis em tempo real.</h1>
                    <p class="max-w-2xl text-base text-slate-400 sm:text-lg">Acesse seu espaço de análise para consultar taxas, acompanhar histórico e tomar decisões seguras com uma interface inspirada em dashboards de fintech.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                        <p class="text-sm uppercase tracking-[0.25em] text-slate-400">Dados</p>
                        <p class="mt-3 text-2xl font-semibold text-white">Histórico</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                        <p class="text-sm uppercase tracking-[0.25em] text-slate-400">Interface</p>
                        <p class="mt-3 text-2xl font-semibold text-white">Moderna</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
                        <p class="text-sm uppercase tracking-[0.25em] text-slate-400">Segurança</p>
                        <p class="mt-3 text-2xl font-semibold text-white">Autenticação</p>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-md rounded-[2rem] border border-white/10 bg-slate-950/95 p-8 shadow-2xl shadow-slate-950/30">
                <div class="mb-8">
                    <p class="text-sm uppercase tracking-[0.35em] text-cyan-300">Bem-vindo de volta</p>
                    <h2 class="mt-3 text-3xl font-semibold text-white">Acesse sua conta</h2>
                    <p class="mt-2 text-slate-400">Entre para acessar o dashboard com suas consultas e histórico.</p>
                </div>
                @yield('content')
                <footer class="mt-8 border-t border-white/10 pt-6 text-sm text-slate-500">
                    <p>© {{ date('Y') }} Monitor Moedas. Design e experiência orientados para produtos SaaS e fintech.</p>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>
