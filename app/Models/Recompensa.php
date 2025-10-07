<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recompensa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'puntos_requeridos',
        'descripcion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'puntos_requeridos' => 'integer',
    ];

    /**
     * Get the canjes for the recompensa.
     */
    public function canjes()
    {
        return $this->hasMany(Canje::class);
    }
}