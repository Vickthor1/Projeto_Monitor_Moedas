<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarPerfilRequest;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function edit(): View
    {
        return view('perfil.index');
    }

    public function update(AtualizarPerfilRequest $request)
    {
        $usuario = auth()->user();
        $usuario->nome = $request->input('nome');

        if ($request->filled('senha')) {
            $usuario->senha = $request->input('senha');
        }

        $usuario->save();

        return back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
