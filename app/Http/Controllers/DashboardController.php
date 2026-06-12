<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboardService): View
    {
        $usuario = auth()->user();

        try {
            $dashboardData = $dashboardService->getDashboardData($usuario);
        } catch (\Throwable $e) {
            \Log::error('Erro ao carregar dashboard', [
                'user_id' => optional($usuario)->id,
                'error' => $e->getMessage(),
            ]);

            $dashboardData = [
                'summary' => [
                    'total_consultas' => 0,
                    'consultas_today' => 0,
                    'most_frequent_currency' => null,
                    'distinct_currencies' => 0,
                    'last_consulta' => null,
                    'chart_labels' => [],
                    'chart_totals' => [],
                ],
                'mainRate' => null,
            ];
        }

        return view('dashboard', [
            'summary' => $dashboardData['summary'],
            'mainRate' => $dashboardData['mainRate'],
        ]);
    }
}
