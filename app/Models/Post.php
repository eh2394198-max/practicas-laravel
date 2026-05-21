<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable; // 1. IMPORTAMOS EL TRAIT (Paso 3 de la guía)

class Post extends Model
{
    use HasFactory;
    use Auditable; // 2. USAMOS EL TRAIT PARA ACTIVAR LA AUDITORÍA

    // Campos habilitados para asignación masiva
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
     * RELACIÓN: Muchos a Muchos
     */
    public function tags() 
    {
        return $this->belongsToMany(Tag::class); 
    }

    /**
     * RELACIÓN: Uno a Muchos
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * RELACIÓN: Uno a Muchos (Archivos Adjuntos - Práctica 3)
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class); 
    }

    /**
     * RELACIÓN: Uno a Muchos (Inversa) - Autor
     */
    public function user() 
    {
        return $this->belongsTo(User::class); 
    }

    /**
     * RELACIÓN: Uno a Muchos (Inversa) - Categoría
     */
    public function category() 
    {
        return $this->belongsTo(Category::class); 
    }
}