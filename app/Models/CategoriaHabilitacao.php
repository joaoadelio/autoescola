<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaHabilitacao extends Model
{
    use HasFactory, SoftDeletes;

    CONST A = 1;
    CONST B = 2;
    CONST C = 3;
    CONST D = 4;
    CONST E = 5;

    CONST AB = [
        self::A,
        self::B
    ];

    protected $fillable = [
        'categoria',
        'descricao'
    ];
}
