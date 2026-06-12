<?php

namespace App\Repositories;

use App\Models\HistoricoConsulta;
use App\Models\Usuario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
        $totalConsultas = $usuario->historicoConsultas()->count();
        $lastConsulta = $usuario->historicoConsultas()->latest('data_consulta')->first();

        $distinctCurrencies = collect($usuario->historicoConsultas()->pluck('moeda_origem')
            ->merge($usuario->historicoConsultas()->pluck('moeda_destino'))
            ->unique())
            ->count();

        $chartData = $usuario->historicoConsultas()
            ->selectRaw('DATE(data_consulta) as label, COUNT(*) as total')
            ->where('data_consulta', '>=', now()->subDays(7))
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return [
            'total_consultas' => $totalConsultas,
            'last_consulta' => $lastConsulta,
            'distinct_currencies' => $distinctCurrencies,
            'chart_labels' => $chartData->pluck('label')->map(fn($date) => date('d/m', strtotime($date)))->toArray(),
            'chart_totals' => $chartData->pluck('total')->toArray(),
        ];
    }
}
