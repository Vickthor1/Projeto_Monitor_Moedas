<?php

namespace App\Http\Controllers;

use App\Repositories\HistoricoConsultaRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoricoController extends Controller
{
    public function index(Request $request, HistoricoConsultaRepository $repository): View
    {
        $usuario = auth()->user();
        $filters = [
            'search' => $request->query('search', ''),
            'sort_field' => $request->query('sort_field', 'data_consulta'),
            'sort_direction' => $request->query('sort_direction', 'desc'),
        ];

        $historico = $repository->paginateByUsuario($usuario, $filters);

        return view('historico.index', [
            'historico' => $historico,
            'filters' => $filters,
        ]);
    }
}
