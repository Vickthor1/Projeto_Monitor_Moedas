<?php

namespace App\Services;

use App\Models\Usuario;
use App\Repositories\HistoricoConsultaRepository;
use App\Services\ExchangeRateService;
use Throwable;

class DashboardService
{
    private HistoricoConsultaRepository $repository;
    private ExchangeRateService $exchangeRateService;

    public function __construct(HistoricoConsultaRepository $repository, ExchangeRateService $exchangeRateService)
    {
        $this->repository = $repository;
        $this->exchangeRateService = $exchangeRateService;
    }

    public function getDashboardData(Usuario $usuario): array
    {
        $summary = $this->repository->getDashboardData($usuario);

        $mainRatePair = ['origem' => 'USD', 'destino' => 'EUR'];

        if ($summary['last_consulta']) {
            $mainRatePair = [
                'origem' => $summary['last_consulta']->moeda_origem,
                'destino' => $summary['last_consulta']->moeda_destino,
            ];
        }

        try {
            $mainRate = $this->exchangeRateService->convert($mainRatePair['origem'], $mainRatePair['destino'], 1);
        } catch (Throwable $e) {
            \Log::warning('Falha ao buscar taxa principal para dashboard', [
                'user_id' => optional($usuario)->id,
                'origem' => $mainRatePair['origem'],
                'destino' => $mainRatePair['destino'],
                'error' => $e->getMessage(),
            ]);
            $mainRate = null;
        }

        return [
            'summary' => $summary,
            'mainRate' => $mainRate,
        ];
    }
}
