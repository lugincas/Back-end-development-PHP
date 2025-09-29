<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MascotaLCU extends Model
{
    use HasFactory;
    // Asociación de la tabla 'mascotas' con el modelo.
    protected $table = 'mascotas';
    // Definición de los atributos asignables en masa.
    protected $fillable = ['nombre', 'descripcion', 'tipo', 'publica', 'megusta', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
