<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $post->name }}</h1>

        <div class="text-lg text-gray-600 mb-6 italic">
            {{ $post->extract }}
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Contenido principal del post --}}
            <div class="lg:col-span-2">
                <figure class="mb-6">
                    <img class="w-full h-96 object-cover object-center rounded-2xl shadow-lg" 
                         src="@if($post->image) {{ Storage::url($post->image->url) }} @else https://cdn.pixabay.com/photo/2016/11/19/14/00/code-1839406_1280.jpg @endif" 
                         alt="{{ $post->name }}">
                </figure>

                <div class="text-base text-gray-700 leading-relaxed">
                    {{ $post->body }}
                </div>
            </div>

            {{-- Barra lateral: Posts relacionados --}}
            <aside>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-100">
                    Más en 
                    <a href="{{ route('posts.category', $post->category) }}" class="text-blue-600 hover:underline">
                        {{ $post->category->name }}
                    </a>
                </h2>

                <ul class="space-y-4">
                    @foreach ($post->category->posts()->where('status', 2)->where('id', '!=', $post->id)->latest('id')->take(4)->get() as $similar)
                        <li>
                            <a class="flex items-center group" href="{{ route('posts.show', $similar) }}">
                                <img class="w-24 h-16 object-cover object-center rounded shadow group-hover:opacity-75 transition" 
                                     src="https://cdn.pixabay.com/photo/2016/11/19/14/00/code-1839406_1280.jpg" alt="">
                                <span class="ml-3 text-gray-700 group-hover:text-blue-600 transition text-sm font-medium">
                                    {{ $similar->name }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

        </div>
    </div>
</x-app-layout>