<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'codigo_postal',
    ];

    /**
     * Get the rutas for the localidad.
     */
    public function rutas()
    {
        return $this->hasMany(Ruta::class);
    }
}