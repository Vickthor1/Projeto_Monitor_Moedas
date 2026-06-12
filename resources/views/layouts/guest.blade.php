<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-md rounded-[2rem] border border-slate-800 bg-slate-900/95 p-8 shadow-2xl shadow-slate-950/40">
            <div class="mb-8 text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Sistema de Monitoramento</p>
                <h1 class="mt-4 text-4xl font-bold">Acesse sua conta</h1>
                <p class="mt-3 text-slate-400">Use suas credenciais para consultar taxas e criar histórico.</p>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>
