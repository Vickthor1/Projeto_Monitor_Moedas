<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\HistoricoConsulta;

#[Fillable(['nome', 'email', 'senha'])]
#[Hidden(['senha', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'senha' => 'hashed',
    ];

    public function getAuthPassword(): string
    {
        return $this->senha;
    }

    public function historicoConsultas(): HasMany
    {
        return $this->hasMany(HistoricoConsulta::class, 'usuario_id');
    }
}
