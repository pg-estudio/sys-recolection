<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoResiduo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_residuos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'frecuencia_recoleccion',
        'puntos_por_kilo',
        'color'
    ];

    /**
     * Get the solicitudes for the tipo de residuo.
     */
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class);
    }
}