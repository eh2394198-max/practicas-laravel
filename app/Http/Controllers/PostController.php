<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Attachment;
use App\Http\Requests\StorePostWithAttachmentsRequest;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

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

    public function store(StorePostWithAttachmentsRequest $request) {
        $category = Category::first(); 

        $post = Post::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'extract' => $request->extract,
            'body' => $request->extract,
            'status' => 2,
            'category_id' => $category->id ?? 1,
            'user_id' => Auth::id(),
        ]);

        // Procesar archivos iniciales
        $this->processAttachments($request, $post);

        return redirect()->route('posts.index')->with('info', 'El post y sus archivos se crearon con éxito'); 
    }

    public function edit(Post $post) {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * MEJORA: Ahora el update procesa nuevos archivos adjuntos.
     */
    public function update(StorePostWithAttachmentsRequest $request, Post $post) {
        
        // Actualizamos los campos de texto
        $post->update($request->validated());

        // PROCESAR NUEVOS ARCHIVOS (Esto es lo que faltaba)
        $this->processAttachments($request, $post);
        
        return redirect()->route('posts.edit', $post)->with('info', 'El post se actualizó con éxito');
    }

    /**
     * MÉTODO PRIVADO: Para reutilizar la lógica de guardado en store y update.
     */
    private function processAttachments(Request $request, Post $post) {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->fileService->storeAttachment($file, $post->id);
            }
        }
    }

    public function destroyAttachment(Attachment $attachment) {
        $this->fileService->deleteAttachment($attachment); 
        return redirect()->back()->with('info', 'Archivo eliminado correctamente'); 
    }

    public function destroy(Post $post) {
        $post->delete();
        return redirect()->route('posts.index')->with('info', 'El post se eliminó correctamente');
    }

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