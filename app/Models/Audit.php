<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Audit extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     * Ajustados según tu esquema de migración de la Práctica 5.
     */
    protected $fillable = [
        'user_name',      // Guardamos el nombre del usuario para el reporte
        'model_type',     // Clase del modelo afectado (ej: App\Models\Post)
        'model_id',       // ID del registro afectado
        'action',         // Acción realizada (create, update, delete)
        'old_values',     // Valores antes del cambio
        'new_values',     // Valores después del cambio
        'ip_address',     // Dirección IP del usuario
        'user_agent'      // Navegador/Dispositivo usado
    ];

    /**
     * Conversión automática de JSON a Arreglos de PHP.
     */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Relación Polimórfica: 
     * Esto permite que la auditoría se conecte con cualquier modelo.
     * Si usaste $table->nullableMorphs('auditable') en la migración, usa 'auditable'.
     * Si usaste campos manuales, puedes usar este método para recuperarlos.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo('auditable', 'model_type', 'model_id');
    }
}