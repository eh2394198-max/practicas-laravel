<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800">Editar Artículo</h1>
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 transition font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al blog
            </a>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            {{-- Formulario principal con enctype para nuevos archivos --}}
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    {{-- Título --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Título del Post</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $post->name) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug (Auto-generado) --}}
                    <div>
                        <label for="slug" class="block text-sm font-bold text-gray-700 mb-1">Slug (URL)</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" readonly
                               class="w-full border-gray-300 bg-gray-50 rounded-lg shadow-sm text-gray-500 cursor-not-allowed">
                        @error('slug')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Extracto --}}
                    <div>
                        <label for="extract" class="block text-sm font-bold text-gray-700 mb-1">Extracto / Resumen</label>
                        <textarea id="extract" name="extract" rows="4" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">{{ old('extract', $post->extract) }}</textarea>
                        @error('extract')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- GESTIÓN DE ADJUNTOS (Práctica 3) --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            Gestión de Archivos Adjuntos
                        </h3>
                        
                        {{-- Subir más archivos --}}
                        <div class="mb-6 bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                            <label class="block text-sm font-semibold text-yellow-800 mb-2">Añadir nuevos archivos:</label>
                            <input type="file" name="attachments[]" id="attachments" multiple 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-600 file:text-white hover:file:bg-yellow-700 cursor-pointer">
                        </div>

                        {{-- Lista de archivos actuales --}}
                        @if($post->attachments->count())
                            <div class="grid grid-cols-1 gap-3">
                                <p class="text-sm font-semibold text-gray-600">Archivos actualmente vinculados:</p>
                                @foreach ($post->attachments as $attachment)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200 group hover:border-red-200 transition shadow-sm">
                                        <div class="flex items-center overflow-hidden">
                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700 truncate" title="{{ $attachment->original_name }}">
                                                {{ $attachment->original_name }}
                                            </span>
                                        </div>
                                        
                                        <button type="button" 
                                                onclick="if(confirm('¿Estás seguro de eliminar este archivo permanentemente?')) document.getElementById('delete-att-{{ $attachment->id }}').submit();"
                                                class="ml-4 p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition"
                                                title="Eliminar archivo">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-sm text-gray-500 italic">No hay archivos adjuntos en este post.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="flex justify-end mt-10 gap-3 border-t pt-6">
                    <a href="{{ route('posts.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 shadow-lg shadow-yellow-100 transition transform active:scale-95">
                        Actualizar Artículo
                    </button>
                </div>
            </form>

            {{-- Formularios ocultos para eliminar cada archivo --}}
            @foreach ($post->attachments as $attachment)
                <form id="delete-att-{{ $attachment->id }}" action="{{ route('attachments.destroy', $attachment) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>

    {{-- Script para autogenerar el Slug --}}
    <script>
        document.getElementById('name').addEventListener('keyup', function() {
            let title = this.value;
            let slug = title.toLowerCase()
                            .replace(/[^\w ]+/g, '')
                            .replace(/ +/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
</x-app-layout>