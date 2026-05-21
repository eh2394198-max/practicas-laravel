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

    // EVIDENCIA 3: Relación Uno a Muchos (Inversa)
    // Un post pertenece a un usuario (Autor)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // EVIDENCIA 3: Relación Uno a Muchos (Inversa)
    // Un post pertenece a una categoría
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // EVIDENCIA 3 (Extra): Relación Muchos a Muchos
    // Un post puede tener muchas etiquetas
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}