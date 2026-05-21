<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Attachment;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $fileService;

    /**
     * Constructor para inyectar el servicio de archivos (Práctica 3)
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Lista de posts para el público y administración
     */
    public function index()
    {
        // Traemos los posts paginados para evitar sobrecargar la página
        $posts = Post::latest('id')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Formulario para crear un nuevo post
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    /**
     * Guardar un post y sus archivos (Dispara Auditoría: created)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:posts,slug',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        // El método create() dispara automáticamente el evento 'created' en el Observer
        $post = Post::create(array_merge($request->all(), [
            'user_id' => Auth::id(),
            'status' => 2 // Publicado por defecto
        ]));

        // Manejo de archivos adjuntos (Práctica 3)
        $this->processAttachments($request, $post);

        return redirect()->route('posts.index')->with('info', 'Post creado y auditado con éxito.');
    }

    /**
     * Ver el detalle de un post
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Post $post)
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Actualizar post (Dispara Auditoría: updated)
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => "required|unique:posts,slug,{$post->id}",
            'extract' => 'required',
        ]);

        /**
         * IMPORTANTE PARA PRÁCTICA 5:
         * Usamos fill() y save() para asegurar que Eloquent detecte los campos 
         * que cambiaron y el Observer pueda registrar old_values y new_values.
         */
        $post->fill($request->all());
        $post->save();

        // Procesar nuevos archivos adjuntos si los hay
        $this->processAttachments($request, $post);
        
        return redirect()->route('posts.index')->with('info', 'Post actualizado y cambios registrados en auditoría.');
    }

    /**
     * Eliminar un post (Dispara Auditoría: deleted)
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('info', 'El post ha sido eliminado.');
    }

    /**
     * Eliminar archivos adjuntos individuales (Práctica 3)
     */
    public function destroyAttachment(Attachment $attachment)
    {
        $this->fileService->deleteAttachment($attachment);
        return redirect()->back()->with('info', 'Archivo adjunto eliminado.');
    }

    /**
     * Lógica privada para procesar archivos (Reutilizable)
     */
    private function processAttachments(Request $request, Post $post)
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->fileService->storeAttachment($file, $post->id);
            }
        }
    }

    // Métodos de filtrado para categorías y etiquetas
    public function category(Category $category) {
        $posts = Post::where('category_id', $category->id)->where('status', 2)->latest('id')->paginate(6);
        return view('posts.index', compact('posts', 'category'));
    }

    public function tag(Tag $tag) {
        $posts = $tag->posts()->where('status', 2)->latest('id')->paginate(6);
        return view('posts.index', compact('posts', 'tag'));
    }
}