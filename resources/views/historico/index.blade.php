@extends('layouts.app')

@section('title', 'Histórico')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Histórico de consultas</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Todas as consultas salvas</h2>
                </div>
                <form method="GET" action="{{ route('historico.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <input name="search" value="{{ $filters['search'] }}" placeholder="Pesquisar..." class="min-w-[220px] rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none" />
                    <button type="submit" class="rounded-3xl bg-sky-500 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-400">Buscar</button>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] bg-slate-900/90 shadow-xl shadow-slate-950/30">
            <div class="grid gap-4 border-b border-slate-800 p-6 sm:grid-cols-[1fr_auto]">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Ordenar por</p>
                    <p class="mt-2 text-sm text-slate-300">{{ ucfirst(str_replace('_', ' ', $filters['sort_field'])) }} / {{ strtoupper($filters['sort_direction']) }}</p>
                </div>
                <div class="grid gap-3 sm:auto-cols-max sm:grid-flow-col">
                    <a href="{{ route('historico.index', array_merge(request()->query(), ['sort_field' => 'data_consulta', 'sort_direction' => $filters['sort_direction'] === 'asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-100 transition hover:bg-slate-800">Data</a>
                    <a href="{{ route('historico.index', array_merge(request()->query(), ['sort_field' => 'valor_convertido', 'sort_direction' => $filters['sort_direction'] === 'asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-100 transition hover:bg-slate-800">Valor</a>
                </div>
            </div>

            <div class="overflow-x-auto p-6">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm text-slate-200">
                    <thead class="text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Data</th>
                            <th class="px-4 py-3">Origem</th>
                            <th class="px-4 py-3">Destino</th>
                            <th class="px-4 py-3">Valor</th>
                            <th class="px-4 py-3">Taxa</th>
                            <th class="px-4 py-3">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historico as $registro)
                            <tr class="border-t border-slate-800 hover:bg-slate-950/80">
                                <td class="px-4 py-4">{{ $registro->data_consulta->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4">{{ $registro->moeda_origem }}</td>
                                <td class="px-4 py-4">{{ $registro->moeda_destino }}</td>
                                <td class="px-4 py-4">{{ number_format($registro->valor_consulta, 2, ',', '.') }}</td>
                                <td class="px-4 py-4">{{ number_format($registro->taxa_cambio, 6, ',', '.') }}</td>
                                <td class="px-4 py-4">{{ number_format($registro->valor_convertido, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-500">Nenhuma consulta encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-800 px-6 py-5 bg-slate-950/80">
                {{ $historico->links() }}
            </div>
        </div>
    </div>
@endsection
