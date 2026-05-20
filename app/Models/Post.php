<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Campos que permitimos llenar (deben coincidir con tu migración)
    protected $fillable = ['name', 'slug', 'extract', 'body', 'status', 'category_id', 'user_id'];

    // Relación uno a muchos inversa (Un post pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación uno a muchos inversa (Un post pertenece a una categoría)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación muchos a muchos (Un post tiene muchas etiquetas)
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}