<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aula extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'aluno_id',
        'categoria_habilitacaos_id',
        'veiculo_id',
        'data_agendamento',
        'hora_agendamento',
        'status',
        'valor_credito'
    ];
}
