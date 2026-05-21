<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PostObserver
{
    /**
     * Se ejecuta después de que un post es creado.
     */
    public function created(Post $post): void
    {
        Audit::create([
            'user_name'      => Auth::user()->name ?? 'Sistema',
            'model_type'     => Post::class,
            'model_id'       => $post->id,
            'action'         => 'created',
            'new_values'     => $post->toArray(),
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }

    /**
     * Se ejecuta después de que un post es actualizado.
     */
    public function updated(Post $post): void
    {
        Audit::create([
            'user_name'      => Auth::user()->name ?? 'Sistema',
            'model_type'     => Post::class,
            'model_id'       => $post->id,
            'action'         => 'updated',
            'old_values'     => $post->getOriginal(),
            'new_values'     => $post->getChanges(),
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }

    /**
     * Se ejecuta después de que un post es eliminado.
     */
    public function deleted(Post $post): void
    {
        Audit::create([
            'user_name'      => Auth::user()->name ?? 'Sistema',
            'model_type'     => Post::class,
            'model_id'       => $post->id,
            'action'         => 'deleted',
            'old_values'     => $post->toArray(),
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }
}