<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'filename',
        'original_name',
        'mime_type',
        'size',
        'path'
    ];

    /**
     * Accesor para URL pública.
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    /**
     * Accesor para tamaño legible.
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
     * PASO 1 (P4): Identificar si el adjunto es una imagen.
     * Permite decidir si mostrar una miniatura o un icono.
     */
    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}