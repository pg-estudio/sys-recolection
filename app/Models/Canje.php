<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'recompensa_id',
        'fecha_canje',
        'estado',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_canje' => 'date',
    ];

    /**
     * Get the user that owns the canje.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the recompensa that owns the canje.
     */
    public function recompensa()
    {
        return $this->belongsTo(Recompensa::class);
    }
}