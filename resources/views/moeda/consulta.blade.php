@extends('layouts.app')

@section('title', 'Consultar Moedas')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.3fr_0.9fr]">
        <section class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Conversão de moedas</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Faça sua consulta</h2>
                </div>
            </div>

            <form action="{{ route('moeda.consultar') }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="text-sm text-slate-300">Moeda de origem</span>
                        <select name="moeda_origem" required class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none">
                            @foreach($currencies as $currency)
                                <option value="{{ $currency }}" @selected(old('moeda_origem') === $currency)>{{ $currency }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-sm text-slate-300">Moeda de destino</span>
                        <select name="moeda_destino" required class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none">
                            @foreach($currencies as $currency)
                                <option value="{{ $currency }}" @selected(old('moeda_destino') === $currency)>{{ $currency }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <label class="block">
                    <span class="text-sm text-slate-300">Valor para conversão</span>
                    <input type="number" step="0.01" min="0" name="valor" value="{{ old('valor') }}" required class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none" />
                </label>

                @if ($errors->any())
                    <div class="rounded-3xl bg-rose-500/10 border border-rose-500/20 p-4 text-sm text-rose-100">
                        <ul class="list-disc space-y-1 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="rounded-3xl bg-sky-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-400">Consultar taxa</button>
            </form>
        </section>

        <section class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Resultado</p>
            <div class="mt-5 space-y-5">
                @if(isset($result))
                    <div class="rounded-[1.75rem] bg-slate-950/90 p-5">
                        <p class="text-sm text-slate-400">Origem • Destino</p>
                        <p class="mt-2 text-2xl font-semibold text-white">{{ $result['moeda_origem'] }} → {{ $result['moeda_destino'] }}</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[1.75rem] bg-slate-950/90 p-5">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Valor informado</p>
                            <p class="mt-2 text-xl font-semibold text-white">{{ number_format($result['valor'], 2, ',', '.') }}</p>
                        </div>
                        <div class="rounded-[1.75rem] bg-slate-950/90 p-5">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Valor convertido</p>
                            <p class="mt-2 text-xl font-semibold text-white">{{ number_format($result['valor_convertido'], 2, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="rounded-[1.75rem] bg-slate-950/90 p-5">
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Taxa de câmbio</p>
                        <p class="mt-2 text-xl font-semibold text-white">{{ number_format($result['taxa'], 6, ',', '.') }}</p>
                        <p class="mt-3 text-sm text-slate-500">Atualizado em {{ $result['data_consulta']->format('d/m/Y H:i:s') }}</p>
                    </div>
                @else
                    <div class="rounded-[1.75rem] bg-slate-950/90 p-5">
                        <p class="text-sm text-slate-400">Faça uma consulta para ver o resultado aqui.</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
