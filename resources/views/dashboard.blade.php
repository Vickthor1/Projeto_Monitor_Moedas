@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.45fr_0.95fr]">
        <div class="space-y-6">
            <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <article class="card card-appear p-6">
                    <p class="metric-label">Total de consultas</p>
                    <p class="metric-value" data-animate-number data-value="{{ $summary['total_consultas'] }}">{{ $summary['total_consultas'] }}</p>
                    <p class="metric-sub">Consultas no histórico do usuário.</p>
                </article>

                <article class="card card-appear p-6">
                    <p class="metric-label">Consultas hoje</p>
                    <p class="metric-value" data-animate-number data-value="{{ $summary['consultas_today'] }}">{{ $summary['consultas_today'] }}</p>
                    <p class="metric-sub">Operações registradas nas últimas 24 horas.</p>
                </article>

                <article class="card card-appear p-6">
                    <p class="metric-label">Moeda mais consultada</p>
                    <p class="metric-value">{{ $summary['most_frequent_currency'] ?? '—' }}</p>
                    <p class="metric-sub">Par mais usado pelo usuário.</p>
                </article>

                <article class="card card-appear p-6">
                    <p class="metric-label">Moedas monitoradas</p>
                    <p class="metric-value" data-animate-number data-value="{{ $summary['distinct_currencies'] }}">{{ $summary['distinct_currencies'] }}</p>
                    <p class="metric-sub">Moedas únicas encontradas no histórico.</p>
                </article>
            </section>

            <section class="glass-card card-appear p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="metric-label">Histórico dos últimos 7 dias</p>
                        <h2 class="text-2xl font-semibold text-white">Consultas por dia</h2>
                    </div>
                    <span class="badge-currency">Resumo semanal</span>
                </div>

                <div class="mt-6 h-[320px] sm:h-[380px]">
                    @if(empty($summary['chart_labels']))
                        <div class="flex h-full items-center justify-center rounded-[1.75rem] border border-dashed border-white/10 bg-slate-950/80 p-6 text-center text-slate-400">
                            <p>Nenhuma consulta nos últimos 7 dias. Faça uma conversão para ver o gráfico.</p>
                        </div>
                    @else
                        <canvas id="dashboardChart" class="h-full w-full"></canvas>
                    @endif
                </div>
            </section>
        </div>

        <div class="space-y-6">
            <article class="glass-card card-appear p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="metric-label">Resumo rápido</p>
                        <h2 class="text-2xl font-semibold text-white">Acompanhe performance</h2>
                    </div>
                    <span class="badge-currency">Atual</span>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[1.75rem] bg-slate-950/80 p-4">
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Última consulta</p>
                        <p class="mt-3 text-xl font-semibold text-white">@if($summary['last_consulta']) {{ $summary['last_consulta']->moeda_origem }} → {{ $summary['last_consulta']->moeda_destino }} @else Nenhuma consulta @endif</p>
                    </div>
                    <div class="rounded-[1.75rem] bg-slate-950/80 p-4">
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Taxa final</p>
                        <p class="mt-3 text-xl font-semibold text-white">@if($summary['last_consulta']) {{ number_format($summary['last_consulta']->taxa_cambio, 6, ',', '.') }} @else -- @endif</p>
                    </div>
                </div>
            </article>

            <article class="glass-card card-appear p-6">
                <p class="metric-label">Notas</p>
                <p class="text-slate-300">Este painel foi redesenhado para um layout mais profissional que combina informações de conversão com métricas de uso.</p>
            </article>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if(!empty($summary['chart_labels']))
        <script>
            const labels = @json($summary['chart_labels']);
            const values = @json($summary['chart_totals']);
            const chartElement = document.getElementById('dashboardChart');

            if (chartElement && typeof Chart !== 'undefined') {
                new Chart(chartElement, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Consultas',
                            data: values,
                            borderColor: 'rgba(0, 212, 255, 1)',
                            backgroundColor: 'rgba(0, 212, 255, 0.16)',
                            fill: true,
                            tension: 0.28,
                            pointRadius: 4,
                            pointBackgroundColor: 'rgba(0, 212, 255, 1)',
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#94a3b8' },
                            },
                            y: {
                                grid: { color: 'rgba(148, 163, 184, 0.12)' },
                                ticks: { color: '#94a3b8', beginAtZero: true },
                            },
                        },
                    },
                });
            }
        </script>
    @endif
@endsection
