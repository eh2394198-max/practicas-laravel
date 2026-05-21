<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::where('status', 2)->latest('id')->paginate(8);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post) {
        return view('posts.show', compact('post'));
    }

    public function create() {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:posts',
            'extract' => 'required',
        ]);

        $category = Category::first(); 
        $user_id = Auth::id();

        $post = new Post();
        $post->name = $request->name;
        $post->slug = $request->slug;
        $post->extract = $request->extract;
        $post->body = $request->extract;
        $post->status = 2;
        $post->category_id = $category->id ?? 1;
        $post->user_id = $user_id;
        
        $post->save();

        return redirect()->route('posts.index')->with('info', 'El post se creó con éxito');
    }

    // --- MÉTODOS PARA EDITAR Y ELIMINAR (Hacen funcionar los botones) ---

    public function edit(Post $post) {
        // Carga el formulario de edición
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post) {
        // Valida los datos antes de actualizar
        $request->validate([
            'name' => 'required',
            'slug' => "required|unique:posts,slug,$post->id",
            'extract' => 'required',
        ]);

        $post->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'extract' => $request->extract,
            'body' => $request->extract,
        ]);

        return redirect()->route('posts.index')->with('info', 'El post se actualizó con éxito');
    }

    public function destroy(Post $post) {
        // Elimina el post de la base de datos
        $post->delete();
        return redirect()->route('posts.index')->with('info', 'El post se eliminó correctamente');
    }

    // --- MÉTODOS DE FILTRADO ---

    public function category(Category $category) {
        $posts = Post::where('category_id', $category->id)
                     ->where('status', 2)
                     ->latest('id')
                     ->paginate(6);
        return view('posts.index', compact('posts', 'category'));
    }

    public function tag(Tag $tag) {
        $posts = $tag->posts()->where('status', 2)->latest('id')->paginate(6);
        return view('posts.index', compact('posts', 'tag'));
    }
}