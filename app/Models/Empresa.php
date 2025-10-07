<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
    ];

    /**
     * Get the rutas for the empresa.
     */
    public function rutas()
    {
        return $this->hasMany(Ruta::class);
    }
}