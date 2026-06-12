<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaMoedaRequest;
use App\Repositories\HistoricoConsultaRepository;
use App\Services\ExchangeRateService;
use Illuminate\View\View;

class MoedaController extends Controller
{
    private array $currencies = [
        'USD', 'EUR', 'GBP', 'BRL', 'JPY', 'CAD', 'AUD', 'CHF', 'CNY', 'ARS', 'MXN', 'INR', 'KRW', 'NZD', 'SGD',
    ];

    public function index(): View
    {
        return view('moeda.consulta', [
            'currencies' => $this->currencies,
        ]);
    }

    public function consult(ConsultaMoedaRequest $request, ExchangeRateService $exchangeRateService, HistoricoConsultaRepository $repository): View
    {
        $data = $request->validated();
        $result = $exchangeRateService->convert($data['moeda_origem'], $data['moeda_destino'], (float) $data['valor']);

        $repository->create(auth()->user(), [
            'moeda_origem' => strtoupper($result['moeda_origem']),
            'moeda_destino' => strtoupper($result['moeda_destino']),
            'valor_consulta' => $result['valor'],
            'valor_convertido' => $result['valor_convertido'],
            'taxa_cambio' => $result['taxa'],
            'data_consulta' => $result['data_consulta'],
            'created_at' => now(),
        ]);

        return view('moeda.consulta', [
            'currencies' => $this->currencies,
            'result' => $result,
        ]);
    }
}
