<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Campos habilitados para asignación masiva (Mass Assignment)
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
     * Un post tiene muchas etiquetas (Tags).
     */
    public function tags() 
    {
        return $this->belongsToMany(Tag::class); 
    }

    /**
     * RELACIÓN: Uno a Muchos
     * Un post tiene muchos comentarios. 
     * (ESTO CORRIGE EL ERROR "NULL" EN TUS EVIDENCIAS)
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * RELACIÓN: Uno a Muchos
     * Un post puede tener muchos archivos adjuntos (Práctica 3).
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class); 
    }

    /**
     * RELACIÓN: Uno a Muchos (Inversa)
     * Un post pertenece a un usuario (Autor).
     */
    public function user() 
    {
        return $this->belongsTo(User::class); 
    }

    /**
     * RELACIÓN: Uno a Muchos (Inversa)
     * Un post pertenece a una categoría.
     */
    public function category() 
    {
        return $this->belongsTo(Category::class); 
    }
}