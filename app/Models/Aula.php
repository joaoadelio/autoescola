<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aula extends Model
{
    use HasFactory, SoftDeletes;

    CONST STATUS = [
        'Agendada' => 'success',
        'Cancelada' => 'danger',
        'Finalizada' => 'secondary',
        'Falta' => 'warning',
        'Analise' => 'yellow'
    ];

    CONST STATUS_EDITAVEIS = [
        'Agendada',
        'Falta'
    ];

    protected $fillable = [
        'aluno_id',
        'categoria_habilitacaos_id',
        'veiculo_id',
        'data_agendamento',
        'hora_agendamento',
        'status',
        'valor_credito',
        'taxa'
    ];

    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaHabilitacao::class, 'categoria_habilitacaos_id');
    }

    public function aluno(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
