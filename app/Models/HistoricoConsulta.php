<?php

namespace App\Models;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoConsulta extends Model
{
    use HasFactory;

    protected $table = 'historico_consultas';

    protected $fillable = [
        'usuario_id',
        'moeda_origem',
        'moeda_destino',
        'valor_consulta',
        'valor_convertido',
        'taxa_cambio',
        'data_consulta',
    ];

    protected $casts = [
        'valor_consulta' => 'decimal:2',
        'valor_convertido' => 'decimal:2',
        'taxa_cambio' => 'decimal:8',
        'data_consulta' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
