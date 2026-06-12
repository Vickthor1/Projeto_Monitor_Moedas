<?php

namespace App\Http\Controllers;

use App\Repositories\HistoricoConsultaRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

        try {
            $historico = $repository->paginateByUsuario($usuario, $filters);
        } catch (\Throwable $e) {
            \Log::error('Erro ao carregar histórico de consultas', [
                'user_id' => optional($usuario)->id,
                'error' => $e->getMessage(),
            ]);

            $historico = new LengthAwarePaginator([], 0, 10, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }

        return view('historico.index', [
            'historico' => $historico,
            'filters' => $filters,
        ]);
    }
}
