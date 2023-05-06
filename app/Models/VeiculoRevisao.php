<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VeiculoRevisao extends Model
{
    use HasFactory;

    protected $table = 'veiculo_revisoes';

    protected $fillable = [
        'veiculo_id',
        'data_agendamento',
        'hora_agendamento'
    ];

    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_id', 'id');
    }
}
