<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Nuestro Blog</h1>
            <p class="mt-3 text-lg text-gray-500">Explora las últimas noticias y tutoriales de desarrollo.</p>
        </div>

        {{-- Filtro de categoría / etiqueta --}}
        @isset($category)
            <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                <p class="text-blue-700 font-bold uppercase text-sm tracking-widest">
                    Categoría: <span class="text-blue-900">{{ $category->name }}</span>
                </p>
            </div>
        @endisset

        @isset($tag)
            <div class="mb-6 p-4 bg-gray-100 border-l-4 border-gray-500 rounded-r-lg">
                <p class="text-gray-700 font-bold uppercase text-sm tracking-widest">
                    Etiqueta: <span class="text-gray-900">#{{ $tag->name }}</span>
                </p>
            </div>
        @endisset

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            
            @foreach ($posts as $post)
                <article class="flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                    
                    <div class="overflow-hidden">
                        <img class="w-full h-52 object-cover transition-transform duration-500 hover:scale-110" 
                             src="@if($post->image) {{ Storage::url($post->image->url) }} @else https://cdn.pixabay.com/photo/2016/11/19/14/00/code-1839406_1280.jpg @endif" 
                             alt="{{ $post->name }}">
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('posts.tag', $tag) }}" 
                                   class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 uppercase">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 min-h-[3.5rem]">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600 transition-colors">
                                {{ $post->name }}
                            </a>
                        </h2>

                        <p class="text-gray-600 text-sm mb-6 line-clamp-3">
                            {{ $post->extract }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('posts.show', $post) }}" 
                               class="text-blue-600 font-bold text-sm inline-flex items-center group">
                                Leer artículo
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach

        </div>

        <div class="mt-12">
            <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>