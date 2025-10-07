<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'empresa_id',
        'localidad_id',
        'dia_recoleccion',
        'turno',
    ];

    /**
     * Get the empresa that owns the ruta.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Get the localidad that owns the ruta.
     */
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    /**
     * Get the solicitudes for the ruta.
     */
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class);
    }
}