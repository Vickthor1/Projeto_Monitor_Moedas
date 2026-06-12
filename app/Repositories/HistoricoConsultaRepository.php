<?php

namespace App\Repositories;

use App\Models\HistoricoConsulta;
use App\Models\Usuario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class HistoricoConsultaRepository
{
    public function paginateByUsuario(Usuario $usuario, array $filters = []): LengthAwarePaginator
    {
        $query = HistoricoConsulta::where('usuario_id', $usuario->id);

        if (!empty($filters['search'])) {
            $search = '%' . mb_strtolower($filters['search']) . '%';
            $query->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(moeda_origem) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(moeda_destino) LIKE ?', [$search])
                    ->orWhereRaw('CAST(valor_consulta AS CHAR) LIKE ?', [$search])
                    ->orWhereRaw('CAST(valor_convertido AS CHAR) LIKE ?', [$search]);
            });
        }

        $sortField = in_array($filters['sort_field'] ?? '', ['data_consulta', 'moeda_origem', 'moeda_destino', 'valor_consulta', 'valor_convertido'])
            ? $filters['sort_field']
            : 'data_consulta';
        $sortDirection = ($filters['sort_direction'] ?? 'desc') === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortField, $sortDirection)->paginate(10)->withQueryString();
    }

    public function create(Usuario $usuario, array $data): HistoricoConsulta
    {
        return $usuario->historicoConsultas()->create($data);
    }

    public function getDashboardData(Usuario $usuario): array
    {
        $baseQuery = HistoricoConsulta::where('usuario_id', $usuario->id);

        $totalConsultas = (clone $baseQuery)->count();
        $lastConsulta = (clone $baseQuery)->latest('data_consulta')->first();

        $currencyUnion = DB::table('historico_consultas')
            ->where('usuario_id', $usuario->id)
            ->selectRaw('moeda_origem as moeda')
            ->unionAll(
                DB::table('historico_consultas')
                    ->where('usuario_id', $usuario->id)
                    ->selectRaw('moeda_destino as moeda')
            );

        $distinctCurrencies = DB::query()
            ->fromSub($currencyUnion, 'currencies')
            ->distinct()
            ->count('moeda');

        $mostFrequentCurrency = DB::query()
            ->fromSub($currencyUnion, 'currencies')
            ->select('moeda', DB::raw('COUNT(*) as total'))
            ->groupBy('moeda')
            ->orderByDesc('total')
            ->limit(1)
            ->first();

        $chartData = (clone $baseQuery)
            ->selectRaw('DATE(data_consulta) as label, COUNT(*) as total')
            ->where('data_consulta', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $consultasHoje = (clone $baseQuery)
            ->whereDate('data_consulta', now())
            ->count();

        return [
            'total_consultas' => $totalConsultas,
            'last_consulta' => $lastConsulta,
            'distinct_currencies' => $distinctCurrencies,
            'most_frequent_currency' => $mostFrequentCurrency?->moeda,
            'consultas_today' => $consultasHoje,
            'chart_labels' => $chartData->pluck('label')->map(fn($date) => date('d/m', strtotime($date)))->toArray(),
            'chart_totals' => $chartData->pluck('total')->toArray(),
        ];
    }
}
