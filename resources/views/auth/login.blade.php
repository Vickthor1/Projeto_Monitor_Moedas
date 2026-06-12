@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    @if($errors->any())
        <div class="mb-6 rounded-3xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-100" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" class="space-y-6" novalidate>
        @csrf

        <label class="field-label">
            <span>E-mail</span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input" aria-label="E-mail de login" />
        </label>

        <label class="field-label input-group">
            <span>Senha</span>
            <input id="password" type="password" name="password" required class="input" aria-label="Senha" />
            <button type="button" class="input-action" id="togglePassword" aria-label="Mostrar ou ocultar senha">Mostrar</button>
        </label>

        <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-slate-400">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/10 bg-slate-800 text-cyan-300 focus:ring-cyan-300" />
                Lembrar-me
            </label>
        </div>

        <button type="submit" class="btn-primary w-full" aria-label="Entrar no sistema">Entrar</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordField = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');

            if (togglePassword && passwordField) {
                togglePassword.addEventListener('click', () => {
                    const isPassword = passwordField.type === 'password';
                    passwordField.type = isPassword ? 'text' : 'password';
                    togglePassword.textContent = isPassword ? 'Ocultar' : 'Mostrar';
                });
            }
        });
    </script>
@endsection
