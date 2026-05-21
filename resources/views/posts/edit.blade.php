<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        {{-- Encabezado --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800">Editar Artículo</h1>
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 transition font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al blog
            </a>
        </div>

        {{-- Alerta de éxito (Si existe en la sesión) --}}
        @if (session('info'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-medium rounded shadow-sm">
                {{ session('info') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" id="edit-post-form">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    {{-- Título --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Título del Post</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $post->name) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('name') border-red-500 @enderror"
                               placeholder="Ej: Mi primera auditoría en Laravel">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug (Auto-generado) --}}
                    <div>
                        <label for="slug" class="block text-sm font-bold text-gray-700 mb-1">Slug (URL Amigable)</label>
                        <div class="relative">
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" readonly
                                   class="w-full border-gray-300 bg-gray-50 rounded-lg shadow-sm text-gray-500 cursor-not-allowed">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                        @error('slug')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Extracto --}}
                    <div>
                        <label for="extract" class="block text-sm font-bold text-gray-700 mb-1">Extracto / Resumen</label>
                        <textarea id="extract" name="extract" rows="3" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('extract') border-red-500 @enderror"
                                  placeholder="Escribe un breve resumen...">{{ old('extract', $post->extract) }}</textarea>
                        @error('extract')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gestión de Adjuntos --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            Archivos Adjuntos
                        </h3>
                        
                        {{-- Dropzone / Input de archivos --}}
                        <div class="mb-6">
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 rounded-lg hover:bg-gray-50 hover:border-yellow-400 transition cursor-pointer">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                        <p class="pt-1 text-sm text-gray-400 font-medium">Click para añadir más archivos</p>
                                    </div>
                                    <input type="file" name="attachments[]" multiple class="opacity-0" />
                                </label>
                            </div>
                        </div>

                        {{-- Lista de archivos actuales --}}
                        <div class="space-y-3">
                            <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Archivos vinculados:</p>
                            @forelse ($post->attachments as $attachment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200 hover:shadow-md transition">
                                    <div class="flex items-center truncate mr-4">
                                        <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 truncate max-w-xs">{{ $attachment->original_name }}</span>
                                    </div>
                                    
                                    <button type="button" 
                                            onclick="confirmDelete('{{ $attachment->id }}')"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition"
                                            title="Eliminar permanentemente">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="text-center py-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                    <p class="text-sm text-gray-400 italic">No hay archivos en este post.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end mt-10 gap-3 border-t pt-6">
                    <button type="button" onclick="window.history.back()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                        Descartar
                    </button>
                    <button type="submit" class="px-10 py-2.5 text-sm font-bold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 shadow-lg shadow-yellow-200 transition transform active:scale-95">
                        Guardar Cambios
                    </button>
                </div>
            </form>

            {{-- Formularios ocultos --}}
            @foreach ($post->attachments as $attachment)
                <form id="delete-att-{{ $attachment->id }}" action="{{ route('attachments.destroy', $attachment) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // Generador de Slug Mejorado (Limpia acentos y caracteres latinos)
        document.getElementById('name').addEventListener('keyup', function() {
            let from = "àáäâèéëêìíïîòóöôùúüûñç";
            let to   = "aaaaeeeeiiiioooouuuunc";
            let str  = this.value.toLowerCase();
            
            for (let i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            let slug = str.replace(/[^\w ]+/g, '')
                          .replace(/ +/g, '-');
            document.getElementById('slug').value = slug;
        });

        // Confirmación de eliminación
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este archivo? Esta acción no se puede deshacer.')) {
                document.getElementById('delete-att-' + id).submit();
            }
        }
    </script>
</x-app-layout>