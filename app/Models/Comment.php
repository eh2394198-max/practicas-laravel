<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Campos que permiten asignación masiva.
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    /**
     * Relación: Un comentario pertenece a un Post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Relación: Un comentario pertenece a un Usuario (Autor).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}