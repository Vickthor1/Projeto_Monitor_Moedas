@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <div class="max-w-3xl space-y-6">
        <section class="glass-card p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="metric-label">Perfil</p>
                    <h2 class="text-3xl font-semibold text-white">Atualize suas informações</h2>
                </div>
                <span class="badge-currency">Segurança</span>
            </div>

            @if(session('success'))
                <div class="rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-100" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('perfil.update') }}" method="POST" class="mt-8 space-y-6" novalidate>
                @csrf
                @method('PUT')

                <label class="field-label">
                    <span>Nome completo</span>
                    <input type="text" name="nome" value="{{ old('nome', auth()->user()->nome) }}" required class="input" aria-label="Nome completo" />
                </label>

                <label class="field-label">
                    <span>Nova senha</span>
                    <input type="password" name="password" class="input" aria-label="Nova senha" />
                </label>

                <label class="field-label">
                    <span>Confirme a nova senha</span>
                    <input type="password" name="password_confirmation" class="input" aria-label="Confirme a nova senha" />
                </label>

                @if ($errors->any())
                    <div class="rounded-3xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-100" role="alert">
                        <ul class="list-disc space-y-1 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="btn-primary">Salvar alterações</button>
            </form>
        </section>
    </div>
@endsection
