@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    @if($errors->any())
        <div class="mb-6 rounded-3xl bg-rose-500/10 border border-rose-500/20 p-4 text-sm text-rose-100">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
        @csrf

        <label class="block">
            <span class="text-sm text-slate-300">E-mail</span>
            <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400" />
        </label>

        <label class="block">
            <span class="text-sm text-slate-300">Senha</span>
            <input type="password" name="senha" required class="mt-2 w-full rounded-3xl border border-slate-800 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400" />
        </label>

        <div class="flex items-center justify-between text-sm text-slate-400">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-700 bg-slate-800 text-sky-400 focus:ring-sky-400" />
                Lembrar-me
            </label>
        </div>

        <button type="submit" class="w-full rounded-3xl bg-sky-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-400">Entrar</button>
    </form>
@endsection
