<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoConsulta extends Model
{
    use HasFactory;

    protected $table = 'historico_consultas';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'moeda_origem',
        'moeda_destino',
        'valor_consulta',
        'valor_convertido',
        'taxa_cambio',
        'data_consulta',
        'created_at',
    ];

    protected $casts = [
        'valor_consulta' => 'decimal:2',
        'valor_convertido' => 'decimal:2',
        'taxa_cambio' => 'decimal:8',
        'data_consulta' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
