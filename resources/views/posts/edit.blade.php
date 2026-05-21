<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Editar Artículo</h1>
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">← Volver al blog</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
            {{-- La ruta debe ser posts.update y pasamos el objeto $post --}}
            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                {{-- Esto es VITAL: le dice a Laravel que es una actualización --}}
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Título del Post</label>
                    <input type="text" name="name" value="{{ old('name', $post->name) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <small class="text-red-600 font-bold">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Slug (URL)</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm">
                    @error('slug')
                        <small class="text-red-600 font-bold">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Extracto --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Extracto / Resumen</label>
                    <textarea name="extract" rows="4" 
                              class="w-full border-gray-300 rounded-md shadow-sm">{{ old('extract', $post->extract) }}</textarea>
                    @error('extract')
                        <small class="text-red-600 font-bold">{{ $message }}</small>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('posts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition font-bold shadow">
                        Actualizar Artículo
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>