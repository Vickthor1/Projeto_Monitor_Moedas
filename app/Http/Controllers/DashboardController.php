<?php

namespace App\Http\Controllers;

use App\Repositories\HistoricoConsultaRepository;
use App\Services\ExchangeRateService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(HistoricoConsultaRepository $repository, ExchangeRateService $exchangeRateService): View
    {
        $usuario = auth()->user();
        $summary = $repository->getDashboardData($usuario);

        $mainRate = null;
        $mainRatePair = ['origem' => 'USD', 'destino' => 'EUR'];

        if ($summary['last_consulta']) {
            $mainRatePair = [
                'origem' => $summary['last_consulta']->moeda_origem,
                'destino' => $summary['last_consulta']->moeda_destino,
            ];
        }

        try {
            $mainRate = $exchangeRateService->convert($mainRatePair['origem'], $mainRatePair['destino'], 1);
        } catch (\Throwable $e) {
            $mainRate = null;
        }

        return view('dashboard', [
            'summary' => $summary,
            'mainRate' => $mainRate,
        ]);
    }
}
