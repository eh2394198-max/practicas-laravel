<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    // Asegúrate de que estos nombres coincidan EXACTAMENTE con tu migración
    protected $fillable = [
        'post_id',
        'filename',
        'original_name',
        'mime_type',
        'size',
        'path'
    ];

    /**
     * MEJORA DE SEGURIDAD: Limpieza automática de archivos.
     * Si borras el registro de la DB, el archivo físico se borra del Storage.
     */
    protected static function booted()
    {
        static::deleted(function ($attachment) {
            if (Storage::disk('public')->exists($attachment->path)) {
                Storage::disk('public')->delete($attachment->path);
            }
        });
    }

    /**
     * Accesor para URL pública.
     * Uso: $attachment->url
     */
    public function getUrlAttribute()
    {
        return $this->path ? Storage::url($this->path) : null;
    }

    /**
     * Accesor para tamaño legible (Optimizado).
     */
    public function getReadableSizeAttribute()
    {
        if (!$this->size) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($this->size, 1024));
        
        return round($this->size / pow(1024, $i), 2) . ' ' . $units[$i];
    }

    /**
     * Identificar si el adjunto es una imagen.
     */
    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Relación inversa con Post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}