<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'descricao',
        'placa',
        'ano_modelo',
        'ano_fabricacao',
        'categoria_habilitacaos_id',
        'instrutor_id'
    ];

    public function categoriaHabilitacao(): BelongsTo
    {
        return $this->belongsTo(CategoriaHabilitacao::class, 'categoria_habilitacaos_id');
    }

    public function instrutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instrutor_id');
    }

    public function revisao(): HasMany
    {
        return $this->hasMany(VeiculoRevisao::class, 'veiculo_id', 'id');
    }
}
