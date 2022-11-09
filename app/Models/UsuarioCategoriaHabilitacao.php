<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioCategoriaHabilitacao extends Model
{
    protected $table = 'usuario_categoria_habilitacaos';

    protected $fillable = [
        'usuario_id',
        'categoria_habilitacao_id',
        'credito'
    ];
}
