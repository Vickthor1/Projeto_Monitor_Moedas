<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ExchangeRateService
{
    private string $apiKey;
    private string $baseUrl = 'https://v6.exchangerate-api.com/v6';

    public function __construct()
    {
        $this->apiKey = config('services.exchangerate.key');

        if (empty($this->apiKey)) {
            throw new RuntimeException('ExchangeRate API key não configurada. Adicione EXCHANGERATE_API_KEY no .env');
        }
    }

    public function convert(string $origem, string $destino, float $valor): array
    {
        $rates = $this->getRates($origem);

        if (!isset($rates['conversion_rates'][$destino])) {
            throw new RuntimeException("Taxa não encontrada para {$origem} -> {$destino}");
        }

        $taxa = (float) $rates['conversion_rates'][$destino];
        $valorConvertido = round($valor * $taxa, 6);

        $this->logConsulta($origem, $destino, $valor, $taxa);

        return [
            'moeda_origem' => strtoupper($origem),
            'moeda_destino' => strtoupper($destino),
            'valor' => $valor,
            'taxa' => $taxa,
            'valor_convertido' => $valorConvertido,
            'data_consulta' => now(),
        ];
    }

    public function getRates(string $base): array
    {
        $base = strtoupper($base);

        return Cache::remember("exchange_rate_{$base}", now()->addMinutes(5), function () use ($base) {
            $response = Http::timeout(10)
                ->retry(2, 100)
                ->get("{$this->baseUrl}/{$this->apiKey}/latest/{$base}");

            if (! $response->successful()) {
                Log::error('Falha ao consultar ExchangeRate API', [
                    'base' => $base,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new RuntimeException('Erro ao conectar na ExchangeRate API. Tente novamente mais tarde.');
            }

            $payload = $response->json();

            if (empty($payload['result']) || $payload['result'] !== 'success') {
                Log::error('Resposta inválida da ExchangeRate API', ['payload' => $payload]);
                throw new RuntimeException('Resposta inválida da ExchangeRate API.');
            }

            return $payload;
        });
    }

    private function logConsulta(string $origem, string $destino, float $valor, float $taxa): void
    {
        Log::info('Consulta de câmbio realizada', [
            'origem' => $origem,
            'destino' => $destino,
            'valor' => $valor,
            'taxa' => $taxa,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
