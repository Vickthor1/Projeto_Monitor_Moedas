<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaMoedaRequest;
use App\Models\Usuario;
use App\Repositories\HistoricoConsultaRepository;
use App\Services\ExchangeRateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function consult(ConsultaMoedaRequest $request, ExchangeRateService $exchangeRateService, HistoricoConsultaRepository $repository): RedirectResponse
    {
        $data = $request->validated();

        try {
            $result = $exchangeRateService->convert($data['moeda_origem'], $data['moeda_destino'], (float) $data['valor']);
        } catch (\Throwable $e) {
            \Log::warning('Falha na ExchangeRate API durante consulta de moeda', [
                'user_id' => optional(auth()->user())->id,
                'origem' => $data['moeda_origem'] ?? null,
                'destino' => $data['moeda_destino'] ?? null,
                'valor' => $data['valor'] ?? null,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('moeda.index')
                ->withErrors(['consulta' => 'Não foi possível buscar a taxa de câmbio no momento. Tente novamente mais tarde.'])
                ->withInput();
        }

        $repository->create(auth()->user(), [
            'moeda_origem' => strtoupper($result['moeda_origem']),
            'moeda_destino' => strtoupper($result['moeda_destino']),
            'valor_origem' => $result['valor'],
            'valor_convertido' => $result['valor_convertido'],
            'taxa_cambio' => $result['taxa'],
            'data_consulta' => $result['data_consulta'],
        ]);

        return redirect()->route('moeda.index')->with('consulta_result', $result);
    }
}
