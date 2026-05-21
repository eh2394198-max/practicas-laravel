<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    /**
     * Campos que permiten asignación masiva.
     */
    protected $fillable = [
        'post_id',
        'filename',
        'original_name',
        'mime_type',
        'size',
        'path'
    ];

    /**
     * MEJORA: Accesor para obtener la URL pública del archivo directamente.
     * Esto facilita mostrar imágenes o enlaces de descarga en la vista.
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    /**
     * MEJORA: Accesor para formatear el tamaño del archivo de bytes a KB/MB.
     * Útil para la evidencia de "Pruebas con diferentes archivos".
     */
    public function getReadableSizeAttribute()
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($this->size, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes / pow(1024, $pow), 2) . ' ' . $units[$pow];
    }

    /**
     * Relación Inversa: Un adjunto pertenece a un Post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}