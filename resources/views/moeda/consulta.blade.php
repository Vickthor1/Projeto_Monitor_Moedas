@extends('layouts.app')

@section('title', 'Consultar Moedas')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.3fr_0.95fr]">
        <section class="glass-card p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="metric-label">Conversão</p>
                    <h2 class="text-3xl font-semibold text-white">Faça sua consulta</h2>
                </div>
                <span class="badge-currency">Tempo real</span>
            </div>

            <form id="currencyConversionForm" action="{{ route('moeda.consultar') }}" method="POST" class="mt-8 space-y-6" novalidate>
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="field-label">
                        <span>Moeda de origem</span>
                        <select id="moeda_origem" name="moeda_origem" required class="input" aria-label="Moeda de origem">
                            @foreach($currencies as $currency)
                                <option value="{{ $currency }}" @selected(old('moeda_origem') === $currency)>{{ $currency }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="field-label">
                        <span>Moeda de destino</span>
                        <select id="moeda_destino" name="moeda_destino" required class="input" aria-label="Moeda de destino">
                            @foreach($currencies as $currency)
                                <option value="{{ $currency }}" @selected(old('moeda_destino') === $currency)>{{ $currency }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-[1fr_auto] items-end">
                    <label class="field-label">
                        <span>Valor para conversão</span>
                        <input type="number" step="0.01" min="0.01" name="valor" value="{{ old('valor') }}" required class="input" aria-label="Valor para conversão" />
                    </label>
                    <button id="swapButton" type="button" class="btn-ghost w-full sm:w-auto">Inverter</button>
                </div>

                @if ($errors->any())
                    <div class="rounded-3xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-100" role="alert">
                        <ul class="list-disc space-y-1 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button id="convertButton" type="submit" class="btn-primary w-full" aria-live="polite">Consultar taxa</button>
            </form>
        </section>

        <section class="glass-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="metric-label">Resultado</p>
                    <h2 class="text-2xl font-semibold text-white">Resumo da conversão</h2>
                </div>
                <span class="badge-currency">Último resultado</span>
            </div>

            <div class="mt-6 space-y-5">
                @php $result = session('consulta_result'); @endphp

                @if($result)
                    @php
                        $formattedDate = null;
                        if (!empty($result['data_consulta'])) {
                            if (is_string($result['data_consulta']) && strtotime($result['data_consulta']) !== false) {
                                $formattedDate = \Carbon\Carbon::parse($result['data_consulta'])->format('d/m/Y H:i:s');
                            } elseif (is_object($result['data_consulta']) && method_exists($result['data_consulta'], 'format')) {
                                $formattedDate = $result['data_consulta']->format('d/m/Y H:i:s');
                            }
                        }
                    @endphp

                    <div class="rounded-[1.75rem] bg-slate-950/85 p-5">
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Origem • Destino</p>
                        <p class="mt-2 text-2xl font-semibold text-white">{{ $result['moeda_origem'] }} → {{ $result['moeda_destino'] }}</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[1.75rem] bg-slate-950/85 p-5">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Valor informado</p>
                            <p class="mt-2 text-xl font-semibold text-white">{{ number_format($result['valor'], 2, ',', '.') }}</p>
                        </div>
                        <div class="rounded-[1.75rem] bg-slate-950/85 p-5">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Valor convertido</p>
                            <p class="mt-2 text-xl font-semibold text-white">{{ number_format($result['valor_convertido'], 2, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] bg-slate-950/85 p-5">
                        <div class="flex items-center justify-between gap-4">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Taxa de câmbio</p>
                            <span class="badge-up">+{{ number_format($result['taxa'], 6, ',', '.') }}</span>
                        </div>
                        <p class="mt-2 text-xl font-semibold text-white">1 {{ $result['moeda_origem'] }} = {{ number_format($result['taxa'], 6, ',', '.') }} {{ $result['moeda_destino'] }}</p>
                        <p class="mt-3 text-sm text-slate-500">Atualizado em {{ $formattedDate ?? '—' }}</p>
                    </div>
                @else
                    <div class="rounded-[1.75rem] bg-slate-950/85 p-5">
                        <p class="text-sm text-slate-400">Faça uma consulta para ver o resultado aqui.</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
