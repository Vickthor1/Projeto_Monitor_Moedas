@extends('layouts.app')

@section('title', 'Histórico')

@section('content')
    <div class="space-y-6">
        <section class="glass-card p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="metric-label">Histórico</p>
                    <h2 class="text-3xl font-semibold text-white">Todas as consultas</h2>
                </div>
                <form method="GET" action="{{ route('historico.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <label class="field-label">
                        <span>Pesquisar</span>
                        <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Buscar por moeda ou valor" class="input" aria-label="Pesquisar histórico" />
                    </label>
                    <button type="submit" class="btn-primary">Buscar</button>
                </form>
            </div>
        </section>

        <section class="card p-6 overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-white/10 pb-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="metric-label">Lista</p>
                    <h2 class="text-2xl font-semibold text-white">Resultados de conversão</h2>
                </div>
                @php
            $symbols = [
                'BRL' => 'R$',
                'USD' => 'US$',
                'EUR' => '€',
                'GBP' => '£',
                'JPY' => '¥',
                'AUD' => 'A$',
                'CAD' => 'C$',];
                @endphp
                @php
                    $currentField = $filters['sort_field'] ?? 'data_consulta';
                    $currentDirection = $filters['sort_direction'] ?? 'desc';
                    $nextDirection = $currentDirection === 'asc' ? 'desc' : 'asc';
                @endphp
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('historico.index', array_merge(request()->query(), ['sort_field' => 'data_consulta', 'sort_direction' => $currentField === 'data_consulta' ? $nextDirection : 'desc'])) }}" class="btn-ghost {{ $currentField === 'data_consulta' ? 'bg-slate-900 text-white shadow-lg' : '' }}">
                        Data
                        @if($currentField === 'data_consulta')
                            <span class="ml-2 text-slate-400">{{ $currentDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </a>
                    <a href="{{ route('historico.index', array_merge(request()->query(), ['sort_field' => 'valor_origem', 'sort_direction' => $currentField === 'valor_origem' ? $nextDirection : 'desc'])) }}" class="btn-ghost {{ $currentField === 'valor_origem' ? 'bg-slate-900 text-white shadow-lg' : '' }}">
                        Valor
                        @if($currentField === 'valor_origem')
                            <span class="ml-2 text-slate-400">{{ $currentDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto p-6">
                <table class="table-modern min-w-full">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>Valor Origem</th>
                            <th>Taxa</th>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historico as $registro)
                            <tr>
                                <td>{{ optional($registro->data_consulta)->format('d/m/Y H:i') ?? '—' }}</td>
                                <td><span class="table-chip">{{ $registro->moeda_origem ?? '—' }}</span></td>
                                <td><span class="table-chip">{{ $symbols[$registro->moeda_destino] ?? $registro->moeda_destino }}</span></td>
                                <td>{{ number_format($registro->valor_origem ?? 0, 2, ',', '.') }}</td>
                                <td>{{ number_format($registro->taxa_cambio ?? 0, 6, ',', '.') }}</td>
                                <td>{{ number_format($registro->valor_convertido ?? 0, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-500">Nenhuma consulta encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 px-6 py-5 bg-slate-950/80">
                {{ $historico->links() }}
            </div>
        </section>
    </div>
@endsection
