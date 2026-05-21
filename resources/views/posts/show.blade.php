<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        {{-- Título y Extracto --}}
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">{{ $post->name }}</h1>
            <p class="text-xl text-gray-600 italic border-l-4 border-blue-500 pl-4">
                {{ $post->extract }}
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Contenido principal --}}
            <div class="lg:col-span-2">
                <figure class="mb-8">
                    @if($post->image)
                        <img class="w-full h-96 object-cover object-center rounded-3xl shadow-xl" 
                             src="{{ Storage::url($post->image->url) }}" alt="{{ $post->name }}">
                    @else
                        <img class="w-full h-96 object-cover object-center rounded-3xl shadow-xl" 
                             src="https://cdn.pixabay.com/photo/2016/11/19/14/00/code-1839406_1280.jpg" alt="Imagen por defecto">
                    @endif
                </figure>

                <div class="text-lg text-gray-700 leading-relaxed mb-12 prose max-w-none">
                    {!! nl2br(e($post->body)) !!}
                </div>

                {{-- SECCIÓN DE ADJUNTOS (Práctica 3) --}}
                @if($post->attachments->count())
                    <div class="bg-blue-50 p-8 rounded-3xl border border-blue-100 shadow-sm">
                        <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                            <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            Material Descargable
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($post->attachments as $attachment)
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-blue-50 flex items-center justify-between hover:shadow-md transition group">
                                    <div class="flex items-center overflow-hidden">
                                        <div class="p-3 bg-blue-100 text-blue-700 rounded-lg mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="truncate">
                                            <p class="text-sm font-bold text-gray-800 truncate" title="{{ $attachment->original_name }}">
                                                {{ $attachment->original_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                {{ strtoupper(explode('/', $attachment->mime_type)[1] ?? 'FILE') }} • {{ $attachment->readable_size }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ Storage::url($attachment->path) }}" 
                                       download="{{ $attachment->original_name }}"
                                       class="ml-4 p-2 text-blue-600 hover:bg-blue-600 hover:text-white rounded-full transition-all" 
                                       title="Descargar archivo">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Barra lateral --}}
            <aside>
                <h2 class="text-2xl font-black text-gray-800 mb-6 flex items-center">
                    <span class="bg-blue-600 w-2 h-8 mr-3 rounded-full"></span>
                    Relacionados
                </h2>

                <ul class="space-y-6">
                    @foreach ($post->category->posts()->where('status', 2)->where('id', '!=', $post->id)->latest('id')->take(4)->get() as $similar)
                        <li>
                            <a class="flex items-start group bg-white p-2 rounded-xl hover:shadow-md transition" href="{{ route('posts.show', $similar) }}">
                                <img class="w-20 h-20 object-cover rounded-lg shadow-sm group-hover:scale-105 transition transform" 
                                     src="https://cdn.pixabay.com/photo/2016/11/19/14/00/code-1839406_1280.jpg" alt="">
                                <div class="ml-4 flex-1">
                                    <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-1">{{ $post->category->name }}</p>
                                    <span class="text-gray-800 group-hover:text-blue-700 transition text-sm font-bold leading-tight">
                                        {{ Str::limit($similar->name, 45) }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

        </div>
    </div>
</x-app-layout>