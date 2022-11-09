<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    CONST ALUNO = 4;

    CONST GRUPO = [
        1 => 'Administrador',
        2 => 'Administrativo',
        3 => 'Instrutor',
        self::ALUNO => 'Aluno',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'grupo',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function categoriaHabilitacao(): BelongsToMany
    {
        return $this->belongsToMany(CategoriaHabilitacao::class, 'usuario_categoria_habilitacaos', 'usuario_id', 'categoria_habilitacaos_id');
    }

    public function aulas()
    {
        return $this->hasMany(Aula::class, 'aluno_id');
    }
}
