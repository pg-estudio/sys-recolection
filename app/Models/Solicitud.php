<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitudes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'tipo_residuo_id',
        'ruta_id',
        'estado',
        'peso',
        'puntos_ganados',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'peso' => 'decimal:2',
        'puntos_ganados' => 'integer',
    ];

    /**
     * Get the user that owns the solicitud.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tipo de residuo that owns the solicitud.
     */
    public function tipoResiduo()
    {
        return $this->belongsTo(TipoResiduo::class);
    }

    /**
     * Get the ruta that owns the solicitud.
     */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }
}