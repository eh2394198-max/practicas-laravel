<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Permitimos la asignación masiva de todos los campos necesarios
    protected $fillable = [
        'name', 
        'slug', 
        'extract', 
        'body', 
        'status', 
        'category_id', 
        'user_id'
    ];

    /**
     * PASO 3: Relación en Post (Práctica 3) [cite: 284]
     * Un post puede tener muchos archivos adjuntos[cite: 286, 287].
     * Esto corrige el error de "count() on null" en las vistas.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class); 
    }

    // EVIDENCIA 3: Relación Uno a Muchos (Inversa)
    // Un post pertenece a un usuario (Autor) [cite: 164, 165]
    public function user() {
        return $this->belongsTo(User::class); 
    }

    // EVIDENCIA 3: Relación Uno a Muchos (Inversa)
    // Un post pertenece a una categoría [cite: 162, 163]
    public function category() {
        return $this->belongsTo(Category::class); 
    }

    // EVIDENCIA 3 (Extra): Relación Muchos a Muchos
    // Un post puede tener muchas etiquetas [cite: 166, 167]
    public function tags() {
        return $this->belongsToMany(Tag::class); 
    }
}