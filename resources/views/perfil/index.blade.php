@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <div class="max-w-3xl space-y-6">
        <section class="rounded-[2rem] bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Perfil</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Atualize suas informações</h2>
                </div>
            </div>

            <form action="{{ route('perfil.update') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                @method('PUT')

                <label class="block">
                    <span class="text-sm text-slate-300">Nome completo</span>
                    <input type="text" name="nome" value="{{ old('nome', auth()->user()->nome) }}" required class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none" />
                </label>

                <label class="block">
                    <span class="text-sm text-slate-300">Nova senha</span>
                    <input type="password" name="senha" class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none" />
                </label>

                <label class="block">
                    <span class="text-sm text-slate-300">Confirme a nova senha</span>
                    <input type="password" name="senha_confirmation" class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none" />
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

                <button type="submit" class="rounded-3xl bg-sky-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-400">Salvar alterações</button>
            </form>
        </section>
    </div>
@endsection
