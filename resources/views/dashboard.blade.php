@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.4fr_1fr]">
        <div class="space-y-6">
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-2">
                <article class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Total de consultas</p>
                    <p class="mt-4 text-4xl font-semibold text-white">{{ $summary['total_consultas'] }}</p>
                    <p class="mt-2 text-sm text-slate-500">Consultas realizadas desde o último login.</p>
                </article>

                <article class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Última consulta</p>
                    <p class="mt-4 text-3xl font-semibold text-white">
                        @if($summary['last_consulta'])
                            {{ $summary['last_consulta']->moeda_origem }} → {{ $summary['last_consulta']->moeda_destino }}
                        @else
                            Nenhuma consulta
                        @endif
                    </p>
                    <p class="mt-2 text-sm text-slate-500">Taxa mais recente usada.</p>
                </article>

                <article class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Taxa atual principal</p>
                    <p class="mt-4 text-4xl font-semibold text-white">
                        @if($mainRate)
                            1 {{ $mainRate['moeda_origem'] }} = {{ number_format($mainRate['taxa'], 6, ',', '.') }} {{ $mainRate['moeda_destino'] }}
                        @else
                            Indisponível
                        @endif
                    </p>
                    <p class="mt-2 text-sm text-slate-500">Atualizada nos últimos 5 minutos.</p>
                </article>

                <article class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Moedas monitoradas</p>
                    <p class="mt-4 text-4xl font-semibold text-white">{{ $summary['distinct_currencies'] }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total de moedas únicas no histórico.</p>
                </article>
            </div>

            <section class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Histórico dos últimos 7 dias</p>
                        <h2 class="mt-2 text-2xl font-semibold text-white">Consultas por dia</h2>
                    </div>
                </div>

                <div class="mt-6 h-[320px] sm:h-[380px]">
                    <canvas id="dashboardChart" class="h-full w-full"></canvas>
                </div>
            </section>
        </div>

        <div class="space-y-6">
            <div class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Bem-vindo</p>
                <h2 class="mt-3 text-2xl font-semibold text-white">Confira as últimas consultas e métricas.</h2>
                <p class="mt-4 text-slate-400">Use o menu lateral para acessar o formulário de conversão, histórico e perfil.</p>
            </div>

            <div class="grid gap-6">
                <article class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Resumo financeiro</p>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-slate-950/80 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Consultas Hoje</p>
                            <p class="mt-3 text-3xl font-semibold text-white">{{ \\App\Models\HistoricoConsulta::whereDate('data_consulta', today())->count() }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-950/80 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Taxa média</p>
                            <p class="mt-3 text-3xl font-semibold text-white">@if($summary['last_consulta']) {{ number_format($summary['last_consulta']->taxa_cambio, 6, ',', '.') }} @else -- @endif</p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
                    <div class="flex items-center justify-between">
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Acompanhamento</p>
                        <span class="rounded-full bg-slate-950/80 px-3 py-1 text-xs uppercase tracking-[0.3em] text-slate-300">Atual</span>
                    </div>
                    <div class="mt-4 space-y-3 text-slate-300">
                        <p>O painel reúne histórico, taxas em tempo real e estatísticas de conversão.</p>
                        <p>Use filtros no histórico para localizar consultas por par de moedas ou resultados.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($summary['chart_labels']);
        const values = @json($summary['chart_totals']);

        new Chart(document.getElementById('dashboardChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Consultas',
                    data: values,
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56, 189, 248, 0.25)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#38bdf8',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: { grid: { color: 'rgba(148,163,184,0.12)' }, ticks: { color: '#94a3b8' } },
                    y: { grid: { color: 'rgba(148,163,184,0.12)' }, ticks: { color: '#94a3b8', beginAtZero: true } },
                },
            },
        });
    </script>
@endsection
