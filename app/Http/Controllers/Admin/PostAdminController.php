<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Audit;
use Illuminate\Http\Request;

class PostAdminController extends Controller
{
    public function __construct()
    {
        // Solo administradores y editores entran aquí
        $this->middleware('role:admin,editor');
    }

    public function index()
    {
        // Cambié 'author' por 'user' porque así está en tu modelo Post.php
        $posts = Post::with('user', 'category')->latest('id')->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        // Usamos una validación rápida para evitar errores
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:posts',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        $post = Post::create(array_merge($data, ['user_id' => auth()->id()]));

        return redirect()->route('admin.posts.show', $post)->with('success', 'Post creado exitosamente');
    }

    public function show(Post $post)
    {
        /**
         * PASO CLAVE PRÁCTICA 5: 
         * Aquí recuperamos el historial de cambios de este post específico 
         * para mostrarlo en la vista detallada.
         */
        $audits = Audit::where('model_type', Post::class)
                      ->where('model_id', $post->id)
                      ->latest()
                      ->get();

        return view('admin.posts.show', compact('post', 'audits'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'name' => 'required',
            'extract' => 'required',
        ]);

        // Al usar update(), el Trait Auditable capturará los cambios automáticamente
        $post->update($data);

        return redirect()->route('admin.posts.show', $post)->with('success', 'Post actualizado');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post eliminado');
    }
}